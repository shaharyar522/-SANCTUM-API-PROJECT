<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Add posts</title>
    <style>
        /* General page styling */
        body {
            font-family: Arial, sans-serif;
            background: #f5f7fa;
            color: #333;
            margin: 0;
            padding: 2rem;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* Headings */
        h1 {
            text-align: center;
            margin-bottom: 2rem;
            font-size: 2rem;
            color: #222;
        }

        /* Form container */
        form {
            background: #fff;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            width: 100%;
        }

        /* Input fields and textarea */
        form input[type="text"],
        form textarea,
        form input[type="file"] {
            width: 100%;
            padding: 0.75rem;
            margin-top: 0.25rem;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 1rem;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        form input[type="text"]:focus,
        form textarea:focus,
        form input[type="file"]:focus {
            border-color: #0077ff;
            box-shadow: 0 0 0 3px rgba(0, 119, 255, 0.15);
            outline: none;
        }

        /* Labels */
        form label {
            font-weight: 600;
            display: block;
            margin-top: 1rem;
            margin-bottom: 0.25rem;
        }

        /* Submit button */
        form button {
            margin-top: 1.5rem;
            padding: 0.75rem 1.2rem;
            background: #0077ff;
            color: #fff;
            border: none;
            border-radius: 6px;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.2s, transform 0.1s;
        }

        form button:hover {
            background: #005fcc;
        }

        form button:active {
            transform: scale(0.98);
        }
    </style>
</head>

<body>
    <h1>Add posts</h1>

    <form id="addForm">
        <div>
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" required>
        </div>

        <div>
            <label for="description">Description:</label>
            <textarea id="description" name="description" required></textarea>
        </div>

        <div>
            <label for="image">Image:</label>
            <input type="file" id="image" name="image" accept="image/*" required>
        </div>

        <div>
            <button type="submit">Submit</button>
        </div>
    </form>



    <script>
        var addForm = document.querySelector("#addForm"); // ✅ correct


        addForm.onsubmit = async (e) => {
            e.preventDefault();

            const token = localStorage.getItem('api_token');

            const title = document.querySelector("#title").value; // ✅ note: .value (not .value())
            const description = document.querySelector("#description").value; // ✅
            const image = document.querySelector("#image").files[0];

            //all form store in js Form Data
            var formData = new FormData();

            formData.append("title", title);
            formData.append("description", description);
            formData.append("image", image);

            let response = await fetch('/api/posts', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'Authorization': `Bearer ${token}`
                    }
                })
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    window.location.href = "http://localhost:8000/allpost";
                });









        }
    </script>
</body>

</html>
