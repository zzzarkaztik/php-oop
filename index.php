<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Task Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="container mt-3">
        <h1>Simple Task Manager</h1>

        <?php
        require_once('Database.php');
        require_once('TaskManager.php');
        require_once('Task.php');

        $database = new Database();
        $taskManager = new TaskManager($database);

        if (isset($_POST['submit'])) {
            $title = $_POST['title'];
            $description = ($_POST['description']);
            $taskManager->createTask($title, $description);
        }

        if (isset($_POST['update'])) {
            $id = $_POST['id'];
            $title = $_POST['title'];
            $description = $_POST['description'];
            $taskManager->updateTask($id, $title, $description);
        }

        if (isset($_POST['delete'])) {
            $id = $_POST['id'];
            $taskManager->deleteTask($id);
        }

        $tasks = $taskManager->getTasks();
        ?>

        <form method="post" class="mb-3">
            <div class="mb-3">
                <label for="title" class="form-label">Task Title</label>
                <input type="text" name="title" class="form-control" id="title" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" class="form-control" id="description" rows="3"></textarea>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Create Task</button>
        </form>

        <?php if (count($tasks) > 0) : ?>
            <h2>Tasks</h2>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tasks as $task) : ?>
                        <tr>
                            <td><?= $task->getTitle() ?></td>
                            <td>
                                <!-- View Button triggers modal -->
                                <button type="button" class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#viewTaskModal<?= $task->getId() ?>">View</button>

                                <!-- Update Button triggers modal -->
                                <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#updateTaskModal<?= $task->getId() ?>">Edit</button>

                                <!-- Delete Button triggers modal -->
                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteTaskModal<?= $task->getId() ?>">Delete</button>
                            </td>
                        </tr>
                        <!-- View Task Modal -->
                        <div class="modal fade" id="viewTaskModal<?= $task->getId() ?>" tabindex="-1" aria-labelledby="viewTaskModalLabel<?= $task->getId() ?>" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="viewTaskModalLabel<?= $task->getId() ?>"><?= $task->getTitle() ?></h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p><?= nl2br(htmlspecialchars($task->getDescription())) ?></p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Update Task Modal -->
                        <div class="modal fade" id="updateTaskModal<?= $task->getId() ?>" tabindex="-1" aria-labelledby="updateTaskModalLabel<?= $task->getId() ?>" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="updateTaskModalLabel<?= $task->getId() ?>">Edit Task</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="post">
                                            <div class="mb-3">
                                                <label for="title-<?= $task->getId() ?>" class="form-label">Task Title</label>
                                                <input type="text" name="title" class="form-control" id="title-<?= $task->getId() ?>" value="<?= $task->getTitle() ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="description-<?= $task->getId() ?>" class="form-label">Description</label>
                                                <textarea name="description" class="form-control" id="description-<?= $task->getId() ?>" rows="3"><?= $task->getDescription() ?></textarea>
                                            </div>
                                            <button type="submit" name="update" class="btn btn-primary">Save changes</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Delete Task Modal -->
                        <div class="modal fade" id="deleteTaskModal<?= $task->getId() ?>" tabindex="-1" aria-labelledby="deleteTaskModalLabel<?= $task->getId() ?>" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteTaskModalLabel<?= $task->getId() ?>">Delete Task</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="post">
                                            <input type="hidden" name="id" value="<?= $task->getId() ?>">
                                            <p>Are you sure you want to delete task "<?= $task->getTitle() ?>"?</p>
                                            <button type="submit" name="delete" class="btn btn-danger">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else : ?>
            <p>No tasks created yet.</p>
        <?php endif; ?>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>