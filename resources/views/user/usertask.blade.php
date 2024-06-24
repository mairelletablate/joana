<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Boxicons -->
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<!-- My CSS -->
	<link rel="stylesheet" href="{{ asset('css/UserDashboard.css') }}">
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
							<a class="active" href="{{ route('dashboard') }}">Task</a>
						</li>
					</ul>
				</div>
			</div>

		


 <script>
        // Drag and Drop Functions
        function allowDrop(event) {
            event.preventDefault();
        }

        function drag(event) {
            event.dataTransfer.setData("text", event.target.id);
        }

        function drop(event) {
			event.preventDefault();
			var data = event.dataTransfer.getData("text");
			var taskElement = document.getElementById(data);
			var taskId = taskElement.id.split("-")[1]; // Extract the task ID from the element's ID

			var newStatus = event.target.closest('.kanban-column').getAttribute('data-status');
			taskElement.closest('.kanban-items').removeChild(taskElement);

			// Update the status attribute in the database
			var form = document.createElement('form');
			form.action = "{{ route('tasks.update') }}"; // Update the route to match your application
			form.method = 'POST';

			var statusInput = document.createElement('input');
			statusInput.type = 'hidden';
			statusInput.name = 'status';
			statusInput.value = newStatus;

			var idInput = document.createElement('input');
			idInput.type = 'hidden';
			idInput.name = 'id';
			idInput.value = taskId;

			form.appendChild(statusInput);
			form.appendChild(idInput);

			document.body.appendChild(form);
			form.submit();
		}


        // Modal Functions
        function openModal(id) {
            document.getElementById('modal-' + id).style.display = "block";
        }

        function closeModal(id) {
            document.getElementById('modal-' + id).style.display = "none";
        }

        function deleteTask(id) {
            // Your logic to delete the task
        }
    </script>



<div class="kanban-board">
        <div class="kanban-column" data-status="todo" ondrop="drop(event)" ondragover="allowDrop(event)">
            <h2 class="todo">To Do</h2>
            <div class="kanban-items">
                @foreach($tasks as $task)
                <div class="task-item" draggable="true" ondragstart="drag(event)" id="task-{{ $task->id }}">
                    <div class="task-title">
                        <h4>Title:</h4>
                        <button onclick="openModal({{ $task->id }})">{{ $task->name }}</button>
                    </div>
                </div>

                <!-- Modal -->
                <div id="modal-{{ $task->id }}" class="modal">
                    <div class="modal-content">
                        <span class="close" onclick="closeModal({{ $task->id }})">&times;</span>
                        <div class="task-name">
                            <h4>Title: {{ $task->name }}</h4>
                        </div>
                        <div class="task-due-date">
                            <h4>Due Date:</h4>
                            <p>{{ $task->due_date }}</p>
                        </div>
                        <div class="task-priority">
                            <h4>Priority:</h4>
                            <p>{{ $task->priority }}</p>
                        </div>
						<form action="{{ route('tasks.destroy', $task->id) }}" method="POST">
							@csrf
							@method('DELETE')
							<button class="delete-button" type="submit" onclick="return confirm('Are you sure you want to delete this task?')">Delete</button>
						</form>					
					</div>
                </div>
                @endforeach
            </div>
        </div>
        <div class="kanban-column" data-status="pending" ondrop="drop(event)" ondragover="allowDrop(event)">
            <h2 class="pending">Pending</h2>
            <div class="kanban-items"></div>
        </div>
        <div class="kanban-column" data-status="finished" ondrop="drop(event)" ondragover="allowDrop(event)">
            <h2 class="finished">Finished</h2>
            <div class="kanban-items"></div>
        </div>
    </div>

			<div class="task-details">
                <h3>Update Task Details</h3>
                <form id="task-form" action="{{ route('tasks.store') }}" method="POST">
                    @csrf 
                    <label for="task-name">Task Name:</label>
                    <input type="text" id="task-name" name="name"> <!-- Add name attribute -->
                    <label for="task-due-date">Due Date:</label>
                    <input type="date" id="task-due-date" name="due_date"> <!-- Add name attribute -->
                    <label for="task-priority">Priority:</label>
                    <select id="task-priority" name="priority"> <!-- Add name attribute -->
                        <option value="Low">Low</option>
                        <option value="Medium">Medium</option>
                        <option value="High">High</option>
                    </select>
                    <button type="submit" class="update-task-btn">Update Task</button> <!-- Ensure type="submit" -->
                </form>
            </div>
		</main>
		<!-- MAIN -->
	</section>
	<!-- CONTENT -->
	

	<script src="{{ asset('js/UserDashboard.js') }}"></script>

</body>
</html>
