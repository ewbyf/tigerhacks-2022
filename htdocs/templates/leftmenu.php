<body>
	<nav>
        <div class="left-menu">
            <div class="left-menu-top">
                <ul>
                    <?php if (isset($_SESSION['username'])): ?>
                        <li><a href="/dashboard">Dashboard</a></li>
                    <?php endif ?>
                    <li><a href="/search">Search</a></li>
                </ul>
            </div>
            <div class="left-menu-bottom">
                <ul>
                    <?php if (!isset($_SESSION['username'])): ?>
                        <li><a href="/register">Register</a></li>
                        <li><a href="/login">Login</a></li>
                    <?php else: ?>
                        <li><a href="/logout">Logout</a></li>
                    <?php endif ?>
                    <li><a href="/support">Support</a></li>
                </ul>
            </div>
        </div>
    </nav>