<?php

namespace App\Rules;

use Closure;
use Carbon\Carbon;
use App\Models\Tournament;
use Illuminate\Contracts\Validation\ValidationRule;

class EventDateWithinTournament implements ValidationRule
{
    protected $tournamentId;
    protected $message;

    /**
     * Create a new rule instance.
     *
     * @param int|null $tournamentId
     */
    public function __construct($tournamentId = null)
    {
        $this->tournamentId = $tournamentId;
    }

    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure(string): void  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Check if tournament ID is valid
        $tournament = Tournament::find($this->tournamentId);

        if (!$tournament) {
            $fail('The selected tournament is invalid.');
            return;
        }

        // Convert the tournament dates to Carbon instances
        $tournamentStartDate = Carbon::parse($tournament->start_date);
        $tournamentEndDate = Carbon::parse($tournament->end_date);

        // Convert the event date (value) to a Carbon instance
        $eventDate = Carbon::parse($value);

        // Check if the event date falls within the tournament's date range using Carbon comparisons
        if ($eventDate->lt($tournamentStartDate) || $eventDate->gt($tournamentEndDate)) {
            $startDate = $tournamentStartDate->format('M d, Y');
            $endDate = $tournamentEndDate->format('M d, Y');

            $fail("The event date must fall within the tournament's date range ($startDate to $endDate).");
        }

    }
}
