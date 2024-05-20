<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home</title>
    <link rel="stylesheet" href="data.css">
</head>
<body>
    <div class="container">
        <h1>Welcome Admin!</h1>
        <form action="logout.php" method="post">
            <button type="submit" class="logout-button">Logout</button>
        </form>
        <div class="button-container">
            <form action="cv.php" method="post">
                <button type="submit">View Applications</button>
            </form>
            <form action="post_vacancy.php" method="get">
                <button type="submit">Post Vacancy</button>
            </form>
        </div>
    </div>
</body>
</html>
