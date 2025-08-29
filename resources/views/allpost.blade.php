<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Simple Data Dashboard</title>
    <style>
        :root {
            --bg: #0f172a;
            /* slate-900 */
            --panel: #111827;
            /* gray-900 */
            --muted: #94a3b8;
            /* slate-400 */
            --text: #e5e7eb;
            /* gray-200 */
            --accent: #22d3ee;
            /* cyan-400 */
            --accent-2: #38bdf8;
            /* sky-400 */
            --danger: #f43f5e;
            /* rose-500 */
            --ok: #22c55e;
            /* green-500 */
            --warn: #f59e0b;
            /* amber-500 */
            --border: #1f2937;
            /* gray-800 */
            --shadow: 0 10px 30px rgba(0, 0, 0, .35);
            --radius: 16px;
        }

        * {
            box-sizing: border-box;
        }

        html,
        body {
            height: 100%;
        }

        body {
            margin: 0;
            font-family: ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Ubuntu, Cantarell, Noto Sans, Helvetica, Arial, "Apple Color Emoji", "Segoe UI Emoji";
            background: radial-gradient(1200px 600px at 10% -10%, rgba(56, 189, 248, .08), transparent), radial-gradient(900px 500px at 90% -20%, rgba(34, 211, 238, .08), transparent), var(--bg);
            color: var(--text);
        }

        header {
            position: sticky;
            top: 0;
            z-index: 5;
            background: linear-gradient(180deg, rgba(17, 24, 39, 0.9), rgba(17, 24, 39, 0.7));
            backdrop-filter: blur(8px);
            border-bottom: 1px solid var(--border);
        }

        .container {
            max-width: 1100px;
            margin: 0 auto;
            padding: 18px 20px;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 700;
            letter-spacing: .2px;
        }

        .brand .dot {
            width: 12px;
            height: 12px;
            border-radius: 999px;
            background: linear-gradient(135deg, var(--accent), var(--accent-2));
            box-shadow: 0 0 20px rgba(56, 189, 248, .6);
        }

        main {
            padding: 28px 20px 60px;
        }

        .shell {
            max-width: 1100px;
            margin: 0 auto;
        }

        /* Toolbar */
        .toolbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 16px;
        }

        h1 {
            font-size: clamp(22px, 4vw, 28px);
            margin: 0;
        }

        .actions {
            display: flex;
            gap: 10px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            border: 1px solid var(--border);
            color: var(--text);
            background: #0b1220;
            padding: 10px 14px;
            border-radius: 999px;
            box-shadow: var(--shadow);
            text-decoration: none;
            font-weight: 600;
            letter-spacing: .2px;
            transition: transform .12s ease, background .12s ease, border-color .12s ease;
            user-select: none;
        }

        .btn:hover {
            transform: translateY(-1px);
            border-color: #334155;
        }

        .btn.primary {
            background: linear-gradient(135deg, var(--accent), var(--accent-2));
            color: #0b1220;
            border: none;
        }

        .btn.danger {
            background: linear-gradient(135deg, #fb7185, var(--danger));
            color: #0b1220;
            border: none;
        }

        /* Table */
        .panel {
            background: rgba(17, 24, 39, .8);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            overflow: hidden;
            box-shadow: var(--shadow);
        }

        .table-wrap {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 760px;
        }

        thead th {
            text-align: left;
            font-size: 14px;
            color: var(--muted);
            font-weight: 700;
            letter-spacing: .3px;
            text-transform: uppercase;
            background: #0b1220;
            border-bottom: 1px solid var(--border);
            padding: 14px 16px;
        }

        tbody td {
            padding: 14px 16px;
            border-bottom: 1px solid var(--border);
            vertical-align: middle;
        }

        tbody tr:hover {
            background: rgba(2, 6, 23, .4);
        }

        .thumb {
            width: 56px;
            height: 56px;
            border-radius: 12px;
            object-fit: cover;
            border: 1px solid #1e293b;
            display: block;
        }

        .title {
            font-weight: 700;
        }

        .desc {
            color: var(--muted);
            font-size: 14px;
            line-height: 1.4;
            max-width: 520px;
        }

        .btn.chip {
            padding: 6px 10px;
            border-radius: 10px;
            font-size: 13px;
            box-shadow: none;
        }

        .btn.outline {
            background: transparent;
        }

        /* Responsive tweaks */
        @media (max-width: 640px) {
            .actions {
                width: 100%;
                justify-content: flex-end;
            }

            .title {
                font-size: 14px;
            }

            .desc {
                max-width: 360px;
            }
        }

    </style>
</head>

<body>
    <header>
        <div class="container">
            <div class="brand">
                <span class="dot"></span>
                <span>Simple Data Board</span>
            </div>
        </div>
    </header>

    <main>
        <div class="shell">
            <!-- Toolbar under header -->
            <div class="toolbar">
                <h1>All Post</h1>
                <div class="actions">
                    <a class="btn primary" href="#" aria-label="Add New Post">➕ Add New</a>
                    <button class="btn danger" id="logoutBtn" aria-label="Logout">⏻ Logout</button>
                </div>
            </div>

            <!-- Data table -->
            <div class="panel">
                <div class="table-wrap">
                    <table role="table" aria-label="Posts">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Update</th>
                                <th>View</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Row 1 -->
                            <tr>
                                <td><img class="thumb" src="https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?q=80&w=240" alt="Post image"></td>
                                <td class="title">Getting Started Guide</td>
                                <td class="desc">Short walkthrough to create your first post, upload an image, and publish safely.</td>
                                <td><button class="btn chip outline" type="button">Update</button></td>
                                <td><button class="btn chip outline" type="button">View</button></td>
                                <td><button class="btn chip outline" type="button">Delete</button></td>
                            </tr>
                            <!-- Row 2 -->
                            <tr>
                                <td><img class="thumb" src="https://images.unsplash.com/photo-1487014679447-9f8336841d58?q=80&w=240" alt="Post image"></td>
                                <td class="title">Design Tips</td>
                                <td class="desc">Clean UI with subtle shadows, rounded corners, and sensible spacing for readability.
                                </td>
                                <td><button class="btn chip outline" type="button">Update</button></td>
                                <td><button class="btn chip outline" type="button">View</button></td>
                                <td><button class="btn chip outline" type="button">Delete</button></td>
                            </tr>
                            <!-- Row 3 -->
                            <tr>
                                <td><img class="thumb" src="https://images.unsplash.com/photo-1498050108023-c5249f4df085?q=80&w=240" alt="Post image"></td>
                                <td class="title">Release Notes v1.0</td>
                                <td class="desc">Initial dashboard layout with header, buttons, and posts table (image, title,
                                    description, actions).</td>
                                <td><button class="btn chip outline" type="button">Update</button></td>
                                <td><button class="btn chip outline" type="button">View</button></td>
                                <td><button class="btn chip outline" type="button">Delete</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>








    <script>
        document.querySelector("#logoutBtn").addEventListener('click', function(event) {
            event.preventDefault(); // 🚀 stop <a> from reloading page

            const token = localStorage.getItem('api_token');

            fetch('/api/logout/', {
                    method: 'POST'
                    , headers: {
                        'Authorization': `Bearer ${token}`
                        , 'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    window.location.href = "/";
                })
                .catch(error => console.error('Error:', error));
        });

    </script>

    {{-- now used form to show table dat --}}

    <script>
        function loadData() {
    const token = localStorage.getItem('api_token');

    if (!token) {
        console.error("No token found. Please login first.");
        // maybe redirect to login page:
        // window.location.href = "/login";
        return;
    }

    fetch('/api/posts', {
        method: 'GET',
        headers: {
            'Authorization': `Bearer ${token}`,
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        console.log("Posts loaded:", data);
    })
    .catch(error => console.error('Error fetching posts:', error));
}

loadData();


    </script>

</body>

</html>
