<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">

<div class="flex min-h-screen">

    <!-- Sidebar -->
    <div class="w-64 bg-gray-900 text-white p-5">
        <h2 class="text-xl font-bold mb-6">Admin Panel</h2>

        <ul>
            <li class="mb-3"><a href="#" class="hover:text-gray-300">Dashboard</a></li>
            <li class="mb-3"><a href="#" class="hover:text-gray-300">Products</a></li>
            <li class="mb-3"><a href="#" class="hover:text-gray-300">Orders</a></li>
            <li class="mb-3"><a href="#" class="hover:text-gray-300">Users</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="flex-1 p-6">

        <h1 class="text-2xl font-bold mb-4">Dashboard</h1>

        <div class="grid grid-cols-3 gap-4">

            <div class="bg-white p-4 rounded shadow">
                <h3 class="text-gray-500">Total Products</h3>
                <p class="text-2xl font-bold">10</p>
            </div>

            <div class="bg-white p-4 rounded shadow">
                <h3 class="text-gray-500">Total Orders</h3>
                <p class="text-2xl font-bold">12 tas puro si raf</p>
            </div>

            <div class="bg-white p-4 rounded shadow">
                <h3 class="text-gray-500">Total Users</h3>
                <p class="text-2xl font-bold">si gab lang </p>
            </div>

        </div>

    </div>

</div>

</body>
</html>
