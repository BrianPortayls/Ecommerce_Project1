<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FreshCart Admin Dashboard</title>

    @vite(['resources/css/styles.css', 'resources/js/script.js'])

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
        rel="stylesheet"
    >
</head>

<body>
    <div class="app-shell">
        <aside class="sidebar" aria-label="Primary">
            <a class="brand" href="#">
                <span class="brand-mark">F</span>

                <span>
                    <strong>FreshCart</strong>
                    <small>Admin</small>
                </span>
            </a>

            <nav class="nav-list">
                <a class="nav-item active" href="#">
                    <span class="icon">D</span>
                    Dashboard
                </a>

                <a class="nav-item" href="#">
                    <span class="icon">O</span>
                    Orders
                </a>

                <a class="nav-item" href="#">
                    <span class="icon">P</span>
                    Products
                </a>

                <a class="nav-item" href="#">
                    <span class="icon">C</span>
                    Customers
                </a>

                <a class="nav-item" href="#">
                    <span class="icon">A</span>
                    Analytics
                </a>

                <a class="nav-item" href="#">
                    <span class="icon">S</span>
                    Settings
                </a>
            </nav>

            <div class="store-card">
                <p>Today</p>
                <strong>96% fulfillment</strong>
                <span>18 orders ready for pickup</span>
            </div>
        </aside>

        <main class="main-content">

            <header class="topbar">
                <div>
                    <p class="eyebrow">Food ecommerce operations</p>
                    <h1>Admin Dashboard</h1>
                </div>

                <div class="topbar-actions">
                    <label class="search">
                        <span>/</span>

                        <input
                            type="search"
                            placeholder="Search orders, products, customers"
                        >
                    </label>

                    <button class="button secondary">
                        Export
                    </button>

                    <button class="button primary">
                        Add Product
                    </button>
                </div>
            </header>

        </main>
    </div>
</body>
</html>