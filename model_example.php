<?php
 
// User Model
class User extends Authenticatable
{
    use Notifiable, HasRoles;

    protected $fillable = [
        'name', 'email', 'password', 'gender', 'guardian_email'
    ];

    public function registrations()
    {
        return $this->hasMany(PlayerRegistration::class);
    }
}

// Tournament Model
class Tournament extends Model
{
    protected $fillable = [
        'league_name', 'status', 'start_date', 'end_date', 'director', 'finance', 'logo', 'tournament_status'
    ];

    public function events()
    {
        return $this->hasMany(TournamentEvent::class);
    }
}

// TournamentEvent Model
class TournamentEvent extends Model
{
    protected $fillable = [
        'tournament_id', 'name', 'type_id', 'start_date', 'end_date', 'registration_deadline'
    ];

    public function tournament()
    {
        return $this->belongsTo(Tournament::class);
    }

    public function categories()
    {
        return $this->belongsToMany(TournamentCategory::class, 'event_category');
    }

    public function type()
    {
        return $this->belongsTo(TournamentType::class);
    }
}

// TournamentType Model
class TournamentType extends Model
{
    protected $fillable = ['name', 'status'];

    public function events()
    {
        return $this->hasMany(TournamentEvent::class);
    }
}

// TournamentCategory Model
class TournamentCategory extends Model
{
    protected $fillable = ['name', 'status'];

    public function options()
    {
        return $this->hasMany(TournamentCategoryOption::class);
    }
}

// TournamentCategoryOption Model
class TournamentCategoryOption extends Model
{
    protected $fillable = ['category_id', 'name', 'status'];

    public function category()
    {
        return $this->belongsTo(TournamentCategory::class);
    }
}

// PlayerRegistration Model
class PlayerRegistration extends Model
{
    protected $fillable = [
        'user_id', 'tournament_event_id', 'category_option_id', 'parent_verification_code', 'player_signature', 'parent_signature'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function event()
    {
        return $this->belongsTo(TournamentEvent::class, 'tournament_event_id');
    }

    public function categoryOption()
    {
        return $this->belongsTo(TournamentCategoryOption::class, 'category_option_id');
    }
}

// OTPVerification Model
class OTPVerification extends Model
{
    protected $fillable = ['email', 'user_id', 'code', 'expiration_date'];
}

// Migration for player registration with signatures and OTP
Schema::create('player_registrations', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->foreignId('tournament_event_id')->constrained('tournament_events')->onDelete('cascade');
    $table->foreignId('category_option_id')->constrained('tournament_category_options')->onDelete('cascade');
    $table->string('parent_verification_code')->nullable();
    $table->string('player_signature');
    $table->string('parent_signature')->nullable();
    $table->timestamps();
});

Schema::create('otp_verifications', function (Blueprint $table) {
    $table->id();
    $table->string('email');
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->string('code');
    $table->timestamp('expiration_date');
    $table->timestamps();
});














// User Model
class User extends Authenticatable
{
    use Notifiable, HasRoles;

    protected $fillable = [
        'name', 'email', 'password', 'gender', 'guardian_email'
    ];

    public function registrations()
    {
        return $this->hasMany(PlayerRegistration::class);
    }
}

// Tournament Models (Same as before)
// ... [Tournament, TournamentEvent, TournamentType, TournamentCategory, TournamentCategoryOption models remain unchanged] ...

// PlayerRegistration Model
class PlayerRegistration extends Model
{
    protected $fillable = [
        'user_id', 'tournament_event_id', 'category_option_id', 'parent_verification_code', 'player_signature', 'parent_signature'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function event()
    {
        return $this->belongsTo(TournamentEvent::class, 'tournament_event_id');
    }

    public function categoryOption()
    {
        return $this->belongsTo(TournamentCategoryOption::class, 'category_option_id');
    }

    // Validation to prevent gender mismatch
    public static function validateGenderEligibility(User $user, TournamentCategoryOption $categoryOption)
    {
        $genderRestrictions = [
            'Male' => ['Male', 'Boy'],
            'Female' => ['Female', 'Girl'],
        ];

        return in_array($categoryOption->name, $genderRestrictions[$user->gender] ?? []);
    }
}

// Controller Example for Player Registration
class PlayerRegistrationController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'tournament_event_id' => 'required|exists:tournament_events,id',
            'category_option_id' => 'required|exists:tournament_category_options,id',
        ]);

        $user = auth()->user();
        $categoryOption = TournamentCategoryOption::findOrFail($request->category_option_id);

        // Check gender eligibility
        if (!PlayerRegistration::validateGenderEligibility($user, $categoryOption)) {
            return back()->withErrors(['gender' => 'You are not eligible to participate in this category based on your gender.']);
        }

        PlayerRegistration::create([
            'user_id' => $user->id,
            'tournament_event_id' => $request->tournament_event_id,
            'category_option_id' => $request->category_option_id,
            'player_signature' => $request->player_signature,
            'parent_signature' => $request->parent_signature,
        ]);

        return redirect()->route('tournament.index')->with('success', 'Registration successful!');
    }
}

// Blade Template Example for Error Display
@if ($errors->has('gender'))
    <div class="text-red-500 mt-2">{{ $errors->first('gender') }}</div>
@endif

<!-- Registration Form -->
<form method="POST" action="{{ route('player-registration.store') }}">
    @csrf
    <!-- Tournament Event & Category Selectors -->
    <select name="tournament_event_id" required>
        @foreach($tournamentEvents as $event)
            <option value="{{ $event->id }}">{{ $event->name }}</option>
        @endforeach
    </select>

    <select name="category_option_id" required>
        @foreach($categoryOptions as $option)
            <option value="{{ $option->id }}">{{ $option->name }}</option>
        @endforeach
    </select>

    <!-- Signatures -->
    <input type="text" name="player_signature" placeholder="Player Signature" required>
    @if(auth()->user()->age < 18)
        <input type="text" name="parent_signature" placeholder="Parent Signature" required>
    @endif

    <button type="submit">Register</button>
</form>
