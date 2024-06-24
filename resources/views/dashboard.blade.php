<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Boxicons -->
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<!-- My CSS -->
	<link rel="stylesheet" href="css/UserDashboard.css">

	<title>DewyDolt App</title>
</head>
<body>

	<!-- SIDEBAR -->
	<section id="sidebar">
		<a href="{{ route('dashboard') }}" class="brand">
			<i class='bx bxs-smile'></i>
			<span class="text">User Dashboard</span>
		</a>
		<ul class="side-menu top">
			<li class="{{ request()->is('dashboard') ? 'active' : '' }}">
				<a href="{{ route('dashboard') }}">
					<i class='bx bxs-dashboard' ></i>
					<span class="text">Home</span>
				</a>
			</li>
			<li class="{{ request()->is('events') ? 'active' : '' }}">
				<a href="{{ route('events') }}">
					<i class='bx bxs-doughnut-chart' ></i>
					<span class="text">Events</span>
				</a>
			</li>
		</ul>
		<ul class="side-menu">
			<li>
    			<a href="{{ route('settings') }}" class="Settings">
        			<i class='bx bxs-cog'></i>
        			<span class="text">Settings</span>
    			</a>
			</li>
			<li>
    			<a href="#" class="logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        			<i class='bx bxs-log-out-circle'></i>
        			<span class="text">Logout</span>
    			</a>
			</li>
			<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    			@csrf
			</form>
			</section>
	<!-- SIDEBAR -->

	<!-- CONTENT -->
	<section id="content">
		<!-- NAVBAR -->
		<nav>
			<i class='bx bx-menu' ></i>
			<a href="{{ route('dashboard') }}" class="nav-link">DewyDoIt</a>
			<input type="checkbox" id="switch-mode" hidden>
			<label for="switch-mode" class="switch-mode"></label>
		</nav>
		<!-- NAVBAR -->

		<!-- MAIN -->
		<main>
			<div class="head-title">
				<div class="left">
					<h1>Welcome User!</h1>
					<ul class="breadcrumb">
						<li>
							<a href="{{ route('dashboard') }}">Dashboard</a>
						</li>
						<li><i class='bx bx-chevron-right' ></i></li>
						<li>
							<a class="active" href="{{ route('dashboard') }}">Home</a>
						</li>
					</ul>
				</div>
			</div>
		</main>
	<!--workspace container-->
	</section>
	<div class="main-content">
        <div class="container mt-5">
            <h2>Let's build a Workspace</h2>
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <form action="{{ route('workspaces.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
		<div id="workspaceList">
            @foreach($workspaces as $workspace)
                <div class="workspace-item mb-3">
                    <h3>{{ $workspace->name }}</h3>
                    <p>{{ $workspace->description }}</p>
                    <form action="{{ route('workspaces.destroy', $workspace->id) }}" method="POST">
                        @csrf
					    @method('DELETE')
                	    <button type="submit" class="btn-delete">Delete</button>
				    </form>
					<form action="{{ route('tasks.index') }}" method="GET">
                        <button type="submit" class="btn-proceed">Proceed</button>
                    </form>
                </div>
            @endforeach
        </div>
    </div>	
	<script src="{{ asset('js/UserDashboard.js') }}"></script>
	<script src="{{ asset('js/workspace.js') }}"></script>
	<script src="js/UserDashboard.js"></script>
</body>
</html>
