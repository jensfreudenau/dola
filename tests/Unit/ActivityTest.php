<?php
/**
 * Created by IntelliJ IDEA.
 * User: jensfreudenau
 * Date: 29.06.18
 * Time: 10:39
 */

namespace Tests\Unit;

use App\Models\Activity;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ActivityTest extends TestCase
{
    use DatabaseMigrations;

    public function __construct()
    {
        parent::__construct();
    }

    public function test_it_records_activity_when_a_competition_is_created()
    {
        $this->signIn();
        $competition = create('App\Models\Competition');
        create('App\Models\Activity');
        $this->assertDatabaseHas(
            'activities',
            [
                'type' => 'created',
                'component' => 'competition',
                'user_id' => auth()->id(),
                'subject_id' => $competition->id,
                'subject_type' => 'App\Model\Competition',
                'created_by' => auth()->id(),
                'updated_by' => auth()->id(),
            ]
        );
        $activity = Activity::first();
        $this->assertEquals($activity->subject->id, $competition->id);
    }



    public function test_it_records_activity_when_a_additional_is_created()
    {
        $this->signIn();
        $additional = create('App\Models\Additional');
        $this->assertEquals(2, Activity::count());
    }

    public function test_create_new_address()
    {
        $this->signIn();
        create('App\Models\Address');
        $this->assertEquals(1, Activity::count());
    }

    public function it_fetches_a_feed_for_any_user()
    {
        $this->signIn();
        create('App\Models\Competition');
        create('App\Models\Competiton', ['user_id' => auth()->id(), 'created_at' => Carbon::now()->subWeek()]);
        $feed = Activity::feed(auth()->user());
        $this->assertTrue($feed->keys()->contains(
            Carbon::now()->format('Y-m-d')
        ));
    }
}
