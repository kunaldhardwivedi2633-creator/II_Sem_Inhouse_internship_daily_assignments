<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sidebar</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial, sans-serif;
}

.sidebar{
    position:fixed;
    top:0;
    left:0;
    width:250px;
    height:100%;
    background:#2c3e50;
    overflow:auto;
}

.sidebar h2{
    color:white;
    text-align:center;
    padding:20px;
    background:#1a252f;
}

.sidebar a{
    display:block;
    color:white;
    padding:15px 20px;
    text-decoration:none;
    transition:0.3s;
    border-bottom:1px solid rgba(255,255,255,0.1);
}

.sidebar a:hover{
    background:#3498db;
    padding-left:30px;
}

.content{
    margin-left:260px;
    padding:20px;
}

</style>

</head>

<body>

<div class="sidebar">

<h2>🎓 Student Panel</h2>

<a href="dashboard.php">🏠 Dashboard</a>

<a href="form.php">➕ Add Student</a>

<a href="students.php">👨‍🎓 View Students</a>

<a href="contact.php">📩 Contact Form</a>

<a href="admin_queries.php">📋 Admin Queries</a>

<a href="logout.php">🚪 Logout</a>

</div>

</body>
</html>