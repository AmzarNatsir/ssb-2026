<?php

namespace App\Models\Workshop\MasterData;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model implements \LaravelFullCalendar\Event
{
    protected $table = 'workshop_schedule';
    protected $fillable = [
        'model',
        'model_id',
        'date',
        'created_by',
        'updated_by'
    ];
    protected $dates = ['date', 'date'];

    public function save(array $options = [])
    {
        $loggedInUser = auth()->user()->id;
        
        if (!$this->created_by) {
            $this->created_by = $loggedInUser;
        }

        $this->updated_by = $loggedInUser;

        return parent::save($options);
    }

    public function schedulable()
    {
        return $this->morphTo('scheduleable', 'model', 'model_id' );
    }

    /**
     * Get the event's id number
     *
     * @return int
     */
    public function getId() {
		return $this->id;
	}

    /**
     * Get the event's title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->schedulable->getScheduleTitle();
    }

    /**
     * Is it an all day event?
     *
     * @return bool
     */
    public function isAllDay()
    {
        return true;
    }

    /**
     * Get the start time
     *
     * @return DateTime
     */
    public function getStart()
    {
        return $this->date;
    }

    /**
     * Get the end time
     *
     * @return DateTime
     */
    public function getEnd()
    {
        return $this->date;
    }
}
