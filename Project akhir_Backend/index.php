<?php 
    $db = mysqli_connect('localhost', 'root', '', 'todolist');

    if (isset($_POST['submit'])) {
        $task = $_POST['task'];
        if (!empty($task)) {
            mysqli_query($db, "INSERT INTO tasks (task) VALUES ('$task')");
            header('location: index.php');
        } 
    }

    if (isset($_POST['edit'])) {
        $task = $_POST['task'];
        $id = $_POST['id'];   
        if (!empty($task)) {
            mysqli_query($db, "UPDATE tasks SET task = '$task' WHERE id = $id");
            header('location: index.php');
        }
    }

    if (isset ($_GET ['delete_task'])) {
        $id = $_GET ['delete_task'];        
        if (is_numeric($id)) {  
            mysqli_query($db, "DELETE FROM tasks WHERE id = $id");
        }
        header ('location: index.php');
    }
    $tasks = mysqli_query ($db, "SELECT * FROM tasks");

    if (isset($_GET['edit_task'])) {
        $id = $_GET['edit_task'];
        $edit_task = mysqli_query($db, "SELECT * FROM tasks WHERE id = $id");
        $task_data = mysqli_fetch_array($edit_task);
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-eidth, intial-scale=1.0">
    <title>To do List</title>
    <link rel="stylesheet" type="text/css" href="CSS/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500&family=Roboto:wght@400;700&display=swap" rel="stylesheet">

</head>
<body>
    <div class = "heading">
        <h1>Your Daily To do List</h1>
    </div>

    <form method = "POST" action = "index.php">
        <input type="text"  class="input_task" name="task" value="<?php echo isset($task_data) ? $task_data['task'] : ''; ?>" required>
        
        <?php if (isset($task_data)) {  ?>
            <input type="hidden" name="id" value="<?php echo $task_data['id']; ?>">
            <button type="submit" class="add" name="edit">update</button>
        <?php } else { ?>
            <button type="submit" class="add" name="submit">Add task</button>
        <?php } ?>
    </form>

    <table>
        <thread>
            <tr>
                <th>Tasks</th>
                <th>Action</th>
            </tr>

            <tbody>
                <?php while ($row = mysqli_fetch_array($tasks)) { ?>
                    <tr>
                        <td class = "task"> 
                            <?php echo $row ['task']; ?> 
                        </td>
                        <td class="action">
                            <a href="index.php?edit_task=<?php echo $row['id']; ?>">edit</a> | 
                            <a href="index.php?delete_task=<?php echo $row['id'] ?>">delete</a>
                        </td>
                    </tr>    
                <?php } ?>  
            </tbody>
        </thread>
    </table>
</body>
</html> 