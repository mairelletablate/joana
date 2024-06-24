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
			</ul>
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
							<a class="active" href="{{ route('events') }}">Events</a>
						</li>
					</ul>
				</div>
			</div>
            <div id="main-container">
            <div id="calendar-container">
                <div id="calendar-header">
                    <button id="prev">‹</button>
                    <div id="month-year"></div>
                    <button id="next">›</button>
                </div>
                <div id="calendar-days">
                    <div class="day-name">Sun</div>
                    <div class="day-name">Mon</div>
                    <div class="day-name">Tue</div>
                    <div class="day-name">Wed</div>
                    <div class="day-name">Thu</div>
                    <div class="day-name">Fri</div>
                    <div class="day-name">Sat</div>
                </div>
                <div id="calendar-dates"></div>
            </div>
			<div id="events-display">
                <h2>Events</h2>
                <ul id="event-list"></ul>
            </div>
        </div> 
		<div id="events-create">
                    <h2>Add Event</h2>
                    <form id="event-form" method="POST" action="{{ route('events.store') }}">
                        @csrf
                        <div>
                            <label for="event-title">Event Title:</label>
                            <input type="text" id="event-title" name="title" required>
                        </div>
                        <div>
                            <label for="event-date">Event Date:</label>
                            <input type="date" id="event-date" name="date" required>
                        </div>
                        <button type="submit">Add Event</button>
                    </form>
        </div>
		</main>
	</section>
	<!-- CONTENT -->
	
	<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js'></script>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="js/UserDashboard.js"></script>
	<script src="js/events.js"></script>

</body>
</html>
