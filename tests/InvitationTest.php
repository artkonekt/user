<?php

declare(strict_types=1);

/**
 * Contains the InvitationTest class.
 *
 * @copyright   Copyright (c) 2020 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2020-12-18
 *
 */

namespace Konekt\User\Tests;

use Carbon\Carbon;
use Illuminate\Support\Facades\Event;
use Konekt\User\Events\UserInvitationCreated;
use Konekt\User\Events\UserInvitationUtilized;
use Konekt\User\Events\UserIsBeingCreatedFromInvitation;
use Konekt\User\Models\Invitation;
use Konekt\User\Models\Profile;
use Konekt\User\Models\User;
use Konekt\User\Models\UserType;
use Konekt\User\Tests\Dummies\CreatesAProfileFromInvitationOptionsListener;
use Konekt\User\Tests\Dummies\PrependsPizzaToUserNameListener;
use Konekt\User\Tests\Dummies\SpecialUser;

class InvitationTest extends TestCase
{
    /** @test */
    public function invitation_can_be_created_with_email_only()
    {
        $invitation = Invitation::create([
            'email' => 'heyho@yadda.yo'
        ]);

        $this->assertInstanceOf(Invitation::class, $invitation);
    }

    /** @test */
    public function the_created_user_is_null_by_default()
    {
        $invitation = Invitation::create([
            'email' => 'heyho@y4dda.yo'
        ]);

        $this->assertNull($invitation->getTheCreatedUser());
    }

    /** @test */
    public function a_hash_gets_automatically_generated()
    {
        $invitation = Invitation::create([
            'email' => 'heyh0@yadda.yo'
        ]);

        $this->assertIsString($invitation->hash);
        $this->assertGreaterThan(90, strlen($invitation->hash));
    }

    /** @test */
    public function hash_can_be_explicitly_set()
    {
        $invitation = Invitation::create([
            'email' => 'cookies@xmas.tr',
            'hash' => 'h1s7lhvernfqrp28oicj;of4uh'
        ]);

        $this->assertEquals('h1s7lhvernfqrp28oicj;of4uh', $invitation->hash);
    }

    /** @test */
    public function options_is_an_empty_array_by_default()
    {
        $invitation = Invitation::create([
            'email' => 'eyho@yadda.yo'
        ]);

        $this->assertIsArray($invitation->options);
        $this->assertEmpty($invitation->options);
    }

    /** @test */
    public function type_is_the_default_user_type_if_unspecified()
    {
        $invitation = Invitation::create([
            'email' => 'yadda@yadda.yo'
        ]);

        $this->assertInstanceOf(UserType::class, $invitation->type);
        $this->assertEquals(UserType::defaultValue(), $invitation->type->value());
    }

    /** @test */
    public function type_can_be_specified()
    {
        $invitation = Invitation::create([
            'email' => 'trump@whitehouse.gov',
            'type' => UserType::ADMIN
        ]);

        $this->assertEquals(UserType::ADMIN, $invitation->type->value());
    }

    /** @test */
    public function it_can_tell_if_it_is_expired()
    {
        $expiredInvitation = Invitation::create([
            'email' => 'meg@meg.gr',
            'expires_at' => Carbon::yesterday()
        ]);

        $activeInvitation = Invitation::create([
            'email' => 'jol@meg.gr',
            'expires_at' => Carbon::tomorrow()
        ]);

        $this->assertTrue($expiredInvitation->isExpired());
        $this->assertFalse($activeInvitation->isExpired());
    }

    /** @test */
    public function the_pending_scope_excludes_expired_items()
    {
        $invitation = Invitation::create([
            'email'      => 'mangozoli@kitchen.be',
            'name'       => 'Mango Zoli',
            'expires_at' => Carbon::now()->subMinute()
        ]);

        $this->assertTrue($invitation->isExpired());
        $this->assertCount(0, Invitation::pending()->get());

        $invitation->expires_at = Carbon::now()->addMinute();
        $invitation->save();

        $this->assertCount(1, Invitation::pending()->get());
    }

    /** @test */
    public function the_pending_scope_excludes_utilized_items()
    {
        $invitation = Invitation::create([
            'email'      => 'bangomargit@kitchen.be',
            'name'       => 'Bango Margit'
        ]);

        $this->assertCount(1, Invitation::pending()->get());

        $invitation->createUser(['password' => 'meh']);

        $this->assertCount(0, Invitation::pending()->get());
    }

    /** @test */
    public function it_can_tell_whether_it_has_been_utilized_already()
    {
        $invitation = Invitation::create([
            'email' => 'mango@kitchen.be',
            'name' => 'Mango'
        ]);

        $this->assertFalse($invitation->hasBeenUtilizedAlready());
        $this->assertTrue($invitation->hasNotBeenUtilizedYet());

        $invitation->createUser(['password' => 'asdqwe']);

        $this->assertTrue($invitation->hasBeenUtilizedAlready());
        $this->assertFalse($invitation->hasNotBeenUtilizedYet());
    }

    /** @test */
    public function it_is_invalid_if_it_has_expired()
    {
        $invitation = Invitation::createInvitation('jan@kuciak.sk', 'Jan Kuciak', null, [], -2);

        $this->assertTrue($invitation->isExpired());
        $this->assertFalse($invitation->isStillValid());
        $this->assertTrue($invitation->isNoLongerValid());
    }

    /** @test */
    public function it_is_invalid_if_it_has_not_yet_expired_but_user_has_been_created_for()
    {
        $invitation = Invitation::createInvitation('jan@kollwitz.platz', 'Jan Hortner');
        $invitation->createUser(['password' => 'meh']);

        $this->assertTrue($invitation->isNotExpired());
        $this->assertTrue($invitation->hasBeenUtilizedAlready());
        $this->assertFalse($invitation->isStillValid());
        $this->assertTrue($invitation->isNoLongerValid());
    }

    /** @test */
    public function it_is_invalid_if_it_has_expired_and_user_has_been_created_for()
    {
        $invitation = Invitation::createInvitation('jan@sofort.de', 'Jan Dreesher', null, [], 0);
        $invitation->createUser(['password' => 'mooh']);

        Carbon::setTestNow(Carbon::tomorrow());
        $this->assertTrue($invitation->isExpired());
        $this->assertTrue($invitation->hasBeenUtilizedAlready());
        $this->assertFalse($invitation->isStillValid());
        $this->assertTrue($invitation->isNoLongerValid());
    }

    /** @test */
    public function it_sets_default_expiration_date_from_config()
    {
        $invitation = Invitation::create([
            'email' => 'pizza@holzmarkt.berlin'
        ]);

        $this->assertEquals(
            config('konekt.user.invitation.default_expiry_days'),
            $invitation->expires_at->diffInDays()
        );
    }

    /** @test */
    public function it_can_be_retrieved_by_hash_with_specific_static_finder_method()
    {
        $hash = '8f2dac384ea6c6ad3gf0hd83jvna86mn6ths';
        Invitation::create([
            'email' => 'tegel@closed.is',
            'hash' => $hash
        ]);

        $invitation = Invitation::findByHash($hash);
        $this->assertInstanceOf(Invitation::class, $invitation);
        $this->assertEquals($hash, $invitation->hash);
    }

    /** @test */
    public function the_static_finder_method_returns_null_if_no_entry_can_be_found_by_hash()
    {
        $this->assertNull(
            Invitation::findByHash('this-hash-does-not-exist')
        );
    }

    /** @test */
    public function it_can_create_a_user_from_the_invitation()
    {
        $invitation = Invitation::create([
            'email' => 'giovanni@gatto.it',
            'name' => 'Giovanni Gatto',
            'type' => UserType::ADMIN,
        ]);

        $user = $invitation->createUser(['password' => 'yourefired']);
        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals('giovanni@gatto.it', $user->email);
        $this->assertEquals('Giovanni Gatto', $user->name);
        $this->assertEquals(UserType::ADMIN, $user->type->value());
    }

    /** @test */
    public function extra_attributes_can_be_set_for_user_creation()
    {
        $invitation = Invitation::create([
            'email' => 'aaron@phillips.sic',
        ]);

        $user = $invitation->createUser([
            'name' => 'Aaron Phillips',
            'password' => 'yourefired',
            'is_active' => true
        ]);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals('aaron@phillips.sic', $user->email);
        $this->assertEquals('Aaron Phillips', $user->name);
        $this->assertTrue($user->is_active);
    }

    /** @test */
    public function a_different_user_class_can_defined_for_user_creation()
    {
        $invitation = Invitation::create([
            'email' => 'special@ginger.ca',
            'name' => 'Emma Taylor',
        ]);

        $user = $invitation->createUser(
            ['password' => 'kidsonly'],
            SpecialUser::class
        );

        $this->assertInstanceOf(SpecialUser::class, $user);
        $this->assertEquals('special@ginger.ca', $user->email);
    }

    /** @test */
    public function the_created_user_can_be_retrieved_after_utilization()
    {
        $invitation = Invitation::create([
            'email' => 'oma@7burg.en',
            'name' => 'Meme',
        ]);

        $user = $invitation->createUser(['password' => 'palincademere']);
        $this->assertEquals($user->id, $invitation->getTheCreatedUser()->id);
    }

    /** @test */
    public function it_sets_the_user_id_and_utilized_at_date_upon_user_creation()
    {
        $invitation = Invitation::create([
            'email' => 'aaron@phillips.nl',
            'name' => 'Aaron Phillips',
        ]);

        $testNow = Carbon::now();
        Carbon::setTestNow($testNow);
        $user = $invitation->createUser(['password' => '2xmastrees']);
        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals($invitation->user_id, $user->id);
        $this->assertInstanceOf(Carbon::class, $invitation->utilized_at);
        $this->assertEquals($testNow->toIso8601String(), $invitation->utilized_at->toIso8601String());
    }

    /** @test */
    public function an_invitation_can_be_created_with_the_factory_method()
    {
        $invitation = Invitation::createInvitation('ich@auch.de');

        $this->assertInstanceOf(Invitation::class, $invitation);
        $this->assertEquals('ich@auch.de', $invitation->email);
    }

    /** @test */
    public function the_invitee_name_can_be_passed_to_the_factory_method()
    {
        $invitation = Invitation::createInvitation('clima@streik.de', 'Clima Streik');

        $this->assertInstanceOf(Invitation::class, $invitation);
        $this->assertEquals('clima@streik.de', $invitation->email);
        $this->assertEquals('Clima Streik', $invitation->name);
    }

    /** @test */
    public function the_type_can_be_passed_to_the_factory_method()
    {
        $invitation = Invitation::createInvitation('connector@api.com', null, UserType::API());

        $this->assertInstanceOf(Invitation::class, $invitation);
        $this->assertEquals('connector@api.com', $invitation->email);
        $this->assertTrue(UserType::API()->equals($invitation->type));
    }

    /** @test */
    public function options_can_be_passed_to_the_factory_method()
    {
        $invitation = Invitation::createInvitation(
            'admin@streik.de',
            null,
            UserType::ADMIN(),
            ['role' => 'admin']
        );

        $this->assertInstanceOf(Invitation::class, $invitation);
        $this->assertTrue(UserType::ADMIN()->equals($invitation->type));
        $this->assertEquals(['role' => 'admin'], $invitation->options);
    }

    /** @test */
    public function expiration_days_can_be_passed_to_the_factory_method()
    {
        $invitation = Invitation::createInvitation('clima@cloud.it', null, null, [], 18);

        $this->assertInstanceOf(Invitation::class, $invitation);
        $this->assertEquals(18, $invitation->expires_at->diffInDays());
    }

    /** @test */
    public function all_fields_can_be_passed_to_the_factory_method()
    {
        $invitation = Invitation::createInvitation(
            'lego@the-floor.berlin',
            'Lego Floor',
            UserType::API(),
            ['role' => 'shop admin'],
            23
        );

        $this->assertInstanceOf(Invitation::class, $invitation);
        $this->assertEquals('lego@the-floor.berlin', $invitation->email);
        $this->assertEquals('Lego Floor', $invitation->name);
        $this->assertTrue(UserType::API()->equals($invitation->type));
        $this->assertEquals(['role' => 'shop admin'], $invitation->options);
        $this->assertEquals(23, $invitation->expires_at->diffInDays());
    }

    /** @test */
    public function the_user_invitation_created_event_gets_fired_if_invitation_gets_created_with_factory_method()
    {
        $this->expectsEvents(UserInvitationCreated::class);
        $invitation = Invitation::createInvitation('bugaloo@boys.us');
    }

    /** @test */
    public function the_user_invitation_utilized_event_gets_fired_upon_user_creation()
    {
        $invitation = Invitation::create([
            'email' => 'unter@meinem-bett.de',
            'name' => 'Unter Meinem Bett'
        ]);

        $this->expectsEvents(UserInvitationUtilized::class);
        $invitation->createUser(['password' => 'somepass']);
    }

    /** @test */
    public function the_user_is_being_created_from_invitation_event_gets_fired_upon_user_creation()
    {
        $invitation = Invitation::create([
            'email' => 'pizza@is-coming.hr',
            'name' => 'Pizza Is Coming'
        ]);

        $this->expectsEvents(UserIsBeingCreatedFromInvitation::class);
        $invitation->createUser(['password' => 'somepass']);
    }

    /** @test */
    public function it_is_possible_to_hook_into_user_creation_and_manipulate_the_user_before_saving()
    {
        Event::listen(
            UserIsBeingCreatedFromInvitation::class,
            PrependsPizzaToUserNameListener::class
        );

        $invitation = Invitation::create([
            'email' => 'pizza@is-coming-in-15-minutes.hr',
            'name' => 'with Tomato 15'
        ]);

        $user = $invitation->createUser(['password' => 'somepass']);
        $this->assertEquals('Pizza with Tomato 15', $user->name);
    }

    /** @test */
    public function options_data_can_be_used_in_user_creation_hook_event()
    {
        Event::listen(
            UserInvitationUtilized::class,
            CreatesAProfileFromInvitationOptionsListener::class
        );

        $invitation = Invitation::create([
            'email' => 'this.pizza@was.very.funky',
            'name' => 'Funky Pizza',
            'options' => [
                'firstname' => 'Funky',
                'lastname' => 'Pizza',
            ]
        ]);

        $user = $invitation->createUser(['password' => 'somepass']);
        $this->assertInstanceOf(Profile::class, $user->profile);
        $this->assertEquals('Pizza', $user->profile->person->lastname);
    }
}
