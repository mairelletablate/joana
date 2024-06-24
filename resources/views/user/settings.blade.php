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
			<li class="{{ request()->is('calendar') ? 'active' : '' }}">
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
							<a class="active" href="{{ route('dashboard') }}">Settings</a>
						</li>
					</ul>
				</div>
			</div>
			<div class="settings-form">
				<form action="{{ route('updateSettings') }}" method="POST">
					@csrf
					<div class="form-group">
						<label for="username">Username</label>
						<input type="text" id="username" name="username" value="{{ auth()->user()->username }}" required>
					</div>
					<div class="form-group">
						<label for="email">Email</label>
						<input type="email" id="email" name="email" value="{{ auth()->user()->email }}" required>
					</div>
					<div class="form-group">
						<label for="phone">Phone</label>
						<input type="tel" id="phone" name="phone" value="{{ auth()->user()->phone }}" required>
					</div>
					<div class="form-group">
						<label for="password">New Password</label>
						<input type="password" id="password" name="password">
					</div>
					<div class="form-group">
						<label for="password_confirmation">Confirm New Password</label>
						<input type="password" id="password_confirmation" name="password_confirmation">
					</div>
					<div class="form-group">
						<button type="submit">Update Settings</button>
					</div>
				</form>
			</div>
		</main>
		<!-- MAIN -->
	</section>
	<!-- CONTENT -->
	

	<script src="js/UserDashboard.js"></script>
</body>
</html>
