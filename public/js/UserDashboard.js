const allSideMenu = document.querySelectorAll('#sidebar .side-menu.top li a');

allSideMenu.forEach(item => {
	const li = item.parentElement;

	item.addEventListener('click', function () {
		allSideMenu.forEach(i => {
			i.parentElement.classList.remove('active');
		});
		li.classList.add('active');
	});
}); 

// TOGGLE SIDEBAR
const menuBar = document.querySelector('#content nav .bx.bx-menu');
const sidebar = document.getElementById('sidebar');
const mainContent = document.querySelector('.main-content');
const workspaceList = document.getElementById('workspaceList');

menuBar.addEventListener('click', function () {
    sidebar.classList.toggle('hide');

    if (sidebar.classList.contains('hide')) {
        mainContent.style.marginLeft = '80px';
        workspaceList.style.marginLeft = '80px';
    } else {
        mainContent.style.marginLeft = '230px'; 
        workspaceList.style.marginLeft = '230px';
    }
});

//tasks
document.addEventListener('DOMContentLoaded', () => {
    const addTaskButton = document.querySelector('.add-task-btn');
    const kanbanColumns = document.querySelectorAll('.kanban-column');
    const editTaskForm = document.getElementById('edit-task-form');
    let currentTask;

    addTaskButton.addEventListener('click', addTask);
    editTaskForm.addEventListener('submit', saveTaskChanges);

    function addTask() {
        const taskName = prompt('Enter the task name:');
        const taskDueDate = prompt('Enter the due date (YYYY-MM-DD):');
        const taskPriority = prompt('Enter the priority level (Low, Medium, High):');

        if (taskName && taskDueDate && taskPriority) {
            const taskItem = document.createElement('div');
            taskItem.classList.add('kanban-item');
            taskItem.setAttribute('draggable', 'true');
            taskItem.innerHTML = `
                <p>${taskName}</p>
                <p>Due: ${taskDueDate}</p>
                <p>Priority: ${taskPriority}</p>
            `;
            taskItem.addEventListener('click', () => editTask(taskItem, taskName, taskDueDate, taskPriority));
            kanbanColumns[0].querySelector('.kanban-items').appendChild(taskItem);
            addDragAndDropHandlers(taskItem);
            saveTaskToDatabase(taskName, taskDueDate, taskPriority, 'todo');
        }
    }

    function editTask(taskItem, name, dueDate, priority) {
        currentTask = taskItem;
        document.getElementById('edit-task-name').value = name;
        document.getElementById('edit-task-due-date').value = dueDate;
        document.getElementById('edit-task-priority').value = priority;
    }

    function saveTaskChanges(event) {
        event.preventDefault();

        const updatedDueDate = document.getElementById('edit-task-due-date').value;
        const updatedPriority = document.getElementById('edit-task-priority').value;

        currentTask.querySelector('p:nth-child(2)').textContent = `Due: ${updatedDueDate}`;
        currentTask.querySelector('p:nth-child(3)').textContent = `Priority: ${updatedPriority}`;

        // Save changes to database (use appropriate task ID or identifier)
        updateTaskInDatabase(currentTask.id, updatedDueDate, updatedPriority);
    }

    function addDragAndDropHandlers(taskItem) {
        taskItem.addEventListener('dragstart', handleDragStart);
        taskItem.addEventListener('dragend', handleDragEnd);
    }

    function handleDragStart(event) {
        event.dataTransfer.setData('text/plain', event.target.textContent);
        event.dataTransfer.effectAllowed = 'move';
        this.style.opacity = '0.4';
    }

    function handleDragEnd(event) {
        this.style.opacity = '1';
    }

    kanbanColumns.forEach(column => {
        const kanbanItems = column.querySelector('.kanban-items');
        kanbanItems.addEventListener('dragover', handleDragOver);
        kanbanItems.addEventListener('drop', handleDrop);
    });

    function handleDragOver(event) {
        event.preventDefault();
        event.dataTransfer.dropEffect = 'move';
    }

    function handleDrop(event) {
        event.preventDefault();
        const taskName = event.dataTransfer.getData('text/plain');
        const taskItem = document.querySelector(`.kanban-item:contains('${taskName}')`);
        if (taskItem) {
            this.appendChild(taskItem);
        }
    }

    function saveTaskToDatabase(name, dueDate, priority, status) {
        // Assuming you have a route named 'tasks.store' for saving tasks
        fetch('{{ route("tasks.store") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                name: name,
                due_date: dueDate,
                priority: priority,
                status: status
            })
        })
        .then(response => response.json())
        .then(data => {
            console.log('Task saved:', data);
            // Assign a unique ID from the database to the task item
            taskItem.id = `task-${data.id}`;
        })
        .catch(error => {
            console.error('Error saving task:', error);
        });
    }

    function updateTaskInDatabase(taskId, dueDate, priority) {
        fetch(`{{ route("tasks.update", "") }}/${taskId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                due_date: dueDate,
                priority: priority
            })
        })
        .then(response => response.json())
        .then(data => {
            console.log('Task updated:', data);
        })
        .catch(error => {
            console.error('Error updating task:', error);
        });
    }
});