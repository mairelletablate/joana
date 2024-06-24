    <?php
    use App\Http\Controllers\AdminController;

    use App\Http\Controllers\ProfileController;
    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\WorkspaceController;
    use App\Http\Controllers\EventController;
    use App\Http\Controllers\SettingsController;
    use App\Http\Controllers\TaskController;


    Route::get('/', function () {
        return view('welcome');
    });

    Route::get('/dashboard', function () { 
        return view('dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');
    Route::get('/events', function () {
        return view('user.events');
    })->name('events');
    Route::get('/settings', function () {
        return view('user.settings');
    })->name('settings');


    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    Route::middleware(['auth'])->group(function () {
        Route::get('/workspace', [WorkspaceController::class, 'index'])->name('workspace.index');
        Route::post('/workspace', [WorkspaceController::class, 'store'])->name('workspace.store');
    });

    Route::middleware(['auth'])->group(function () {
        Route::get('/events', [EventController::class, 'index'])->name('events');
        Route::post('/events', [EventController::class, 'store'])->name('events.store');
    });

    Route::get('/dashboard', [WorkspaceController::class, 'create'])->name('dashboard');
    Route::post('/workspaces', [WorkspaceController::class, 'store'])->name('workspaces.store');
    Route::delete('/workspaces/{id}', [WorkspaceController::class, 'destroy'])->name('workspaces.destroy');

    Route::get('/user/task', [WorkspaceController::class, 'task'])->name('user.task');
    Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');

    Route::delete('/tasks/{id}', [TaskController::class, 'destroy'])->name('tasks.destroy');

    //store task
    Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');

    // Route to display tasks
    Route::get('/user/tasks', [TaskController::class, 'index'])->name('tasks.index');

    Route::get('/events', [EventController::class, 'index'])->name('events');
    Route::post('/updateSettings', [SettingsController::class, 'updateSettings'])->name('updateSettings');

    require __DIR__.'/auth.php';
    Route::get('admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard')->middleware(['auth','admin']);

