<?php
session_start();

// Initialize session if tasks don't exist
if (!isset($_SESSION['tasks'])) {
    $_SESSION['tasks'] = [];
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    handleFormSubmission();
}

function handleFormSubmission() {
    if (isset($_POST['addTask'])) {
        addTask();
    } elseif (isset($_POST['editTask'])) {
        editTask();
    } elseif (isset($_POST['deleteTask'])) {
        deleteTask();
    } elseif (isset($_POST['toggleTask'])) {
        toggleTask();
    }
}

function addTask() {
    $taskText = trim($_POST['taskText']);
    $taskTime = $_POST['taskTime'];
    if (!empty($taskText) && !empty($taskTime)) {
        $task = [
            'id' => time(),
            'text' => $taskText,
            'time' => $taskTime,
            'completed' => false,
            'completedAt' => null
        ];
        $_SESSION['tasks'][] = $task;
    }
    redirect();
}

function editTask() {
    $taskId = $_POST['taskId'];
    $taskText = trim($_POST['taskText']);
    $taskTime = $_POST['taskTime'];
    foreach ($_SESSION['tasks'] as &$task) {
        if ($task['id'] == $taskId) {
            $task['text'] = $taskText;
            $task['time'] = $taskTime;
            break;
        }
    }
    redirect();
}

function deleteTask() {
    $taskId = $_POST['taskId'];
    $_SESSION['tasks'] = array_filter($_SESSION['tasks'], function($task) use ($taskId) {
        return $task['id'] != $taskId;
    });
    redirect();
}

function toggleTask() {
    $taskId = $_POST['taskId'];
    foreach ($_SESSION['tasks'] as &$task) {
        if ($task['id'] == $taskId) {
            $task['completed'] = !$task['completed'];
            $task['completedAt'] = $task['completed'] ? date('Y-m-d H:i:s') : null;
            break;
        }
    }
    redirect();
}

function redirect() {
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-do List with Time and Completion Status</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .completed-task { text-decoration: line-through; color: gray; }
    </style>
</head>
<body class="bg-gray-100">
    <div class="flex justify-center items-center min-h-screen">
        <div class="w-full max-w-3xl bg-white rounded-lg p-4 shadow-lg">
            <div class="flex justify-between items-center mb-4">
                <input type="text" id="searchInput" placeholder="Search tasks..." class="border p-2 w-full rounded-md" onkeyup="searchTasks()">
                <button class="ml-2 bg-blue-500 text-white px-4 py-2 rounded-md" onclick="showModal('addTaskModal')">Add</button>
            </div>

            <ul id="taskItems" class="space-y-4">
                <?php foreach ($_SESSION['tasks'] as $task): ?>
                    <li id="<?= $task['id'] ?>" class="flex items-center gap-2">
                        <div class="flex-grow h-12 bg-gray-100 rounded-md flex items-center px-3">
                            <form method="POST" class="m-0">
                                <input type="hidden" name="toggleTask" value="1">
                                <input type="hidden" name="taskId" value="<?= $task['id'] ?>">
                                <button type="submit" id="check<?= $task['id'] ?>" class="w-7 h-7 rounded-full border <?= $task['completed'] ? 'bg-green-500' : 'bg-white' ?>">
                                    <i class="fa fa-check text-white"></i>
                                </button>
                            </form>
                            <span id="text<?= $task['id'] ?>" class="ml-4 font-semibold <?= $task['completed'] ? 'completed-task' : '' ?>">
                                <?= htmlspecialchars($task['text']) ?>
                            </span>
                        </div>
                        <span class="w-32 h-12 bg-gray-100 rounded-md text-sm text-gray-700 flex justify-center items-center">
                            <?= $task['time'] ?>
                        </span>
                        <span class="w-40 h-12 bg-gray-100 rounded-md text-sm text-gray-700 flex justify-center items-center">
                            <?= $task['completed'] ? 'Completed at: ' . $task['completedAt'] : 'Not completed' ?>
                        </span>
                        <button class="bg-yellow-500 text-white px-2 py-1 rounded-md" onclick="showEditTaskModal(<?= $task['id'] ?>, '<?= htmlspecialchars($task['text'], ENT_QUOTES) ?>', '<?= $task['time'] ?>')">Edit</button>
                        <button class="bg-red-500 text-white px-2 py-1 rounded-md" onclick="showDeleteTaskModal(<?= $task['id'] ?>)">Delete</button>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>

    <!-- Add Task Modal -->
    <div id="addTaskModal" class="fixed z-10 inset-0 hidden bg-gray-900 bg-opacity-50 flex justify-center items-center">
        <div class="bg-white rounded-lg p-6">
            <h2 class="text-xl font-semibold mb-4">Add New Task</h2>
            <form method="POST">
                <input type="hidden" name="addTask" value="1">
                <input type="text" name="taskText" placeholder="Enter task name" class="border p-2 w-full rounded-md mb-4" required>
                <input type="time" name="taskTime" class="border p-2 w-full rounded-md mb-4" required>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Add Task</button>
                <button type="button" class="bg-gray-300 px-4 py-2 rounded-md ml-2" onclick="hideModal('addTaskModal')">Cancel</button>
            </form>
        </div>
    </div>

    <!-- Edit Task Modal -->
    <div id="editTaskModal" class="fixed z-10 inset-0 hidden bg-gray-900 bg-opacity-50 flex justify-center items-center">
        <div class="bg-white rounded-lg p-6">
            <h2 class="text-xl font-semibold mb-4">Edit Task</h2>
            <form method="POST">
                <input type="hidden" name="editTask" value="1">
                <input type="hidden" name="taskId" id="editTaskId">
                <input type="text" name="taskText" id="editTaskText" class="border p-2 w-full rounded-md mb-4" required>
                <input type="time" name="taskTime" id="editTaskTime" class="border p-2 w-full rounded-md mb-4" required>
                <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded-md">Edit Task</button>
                <button type="button" class="bg-gray-300 px-4 py-2 rounded-md ml-2" onclick="hideModal('editTaskModal')">Cancel</button>
            </form>
        </div>
    </div>

    <!-- Delete Task Modal -->
    <div id="deleteTaskModal" class="fixed z-10 inset-0 hidden bg-gray-900 bg-opacity-50 flex justify-center items-center">
        <div class="bg-white rounded-lg p-6">
            <h2 class="text-xl font-semibold mb-4">Delete Task</h2>
            <form method="POST">
                <input type="hidden" name="deleteTask" value="1">
                <input type="hidden" name="taskId" id="deleteTaskId">
                <p>Are you sure you want to delete this task?</p>
                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-md">Delete</button>
                <button type="button" class="bg-gray-300 px-4 py-2 rounded-md ml-2" onclick="hideModal('deleteTaskModal')">Cancel</button>
            </form>
        </div>
    </div>

    <script>
        function showModal(modalId) {
            document.getElementById(modalId).style.display = 'flex';
        }

        function hideModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }

        function showEditTaskModal(id, text, time) {
            document.getElementById('editTaskId').value = id;
            document.getElementById('editTaskText').value = text;
            document.getElementById('editTaskTime').value = time;
            showModal('editTaskModal');
        }

        function showDeleteTaskModal(id) {
            document.getElementById('deleteTaskId').value = id;
            showModal('deleteTaskModal');
        }

        function searchTasks() {
            const input = document.getElementById('searchInput').value.toLowerCase();
            const tasks = document.querySelectorAll('#taskItems li');

            tasks.forEach(task => {
                const taskText = task.querySelector('span[id^="text"]').innerText.toLowerCase();
                task.style.display = taskText.includes(input) ? '' : 'none';
            });
        }
    </script>
</body>
</html>