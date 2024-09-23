<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>TaskBoard</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>
    <header class="main-header">
        <div class="wrapper">
            <h2 class="header-text">TaskBoard</h2>
        </div>
    </header>
    @php
        function countTasks($category, $tasks)
        {
            $arr = array_filter(
                $tasks,
                function ($task) use ($category) {
                    return (int)$task['category'] == (int)$category;
                },
                ARRAY_FILTER_USE_BOTH,
            );
            return count($arr);
        }
    @endphp
    <div class="taskboard-container">
        <div class="wrapper">
            <ul class="taskcategory-list">
                @foreach ($categories as $category)
                    <li class="taskcategory-column">
                        <div class="column-header">
                            <div class="title">
                                {{ $category->name }}
                            </div>
                            <div class="actions">
                                <div class="task-count">
                                    {{ countTasks((int) $category->id, $tasks->toArray()) }}
                                </div>
                                <button class="icon-btn" title="Add task">
                                    <span class="icon-container">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                            <path
                                                d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32l0 144L48 224c-17.7 0-32 14.3-32 32s14.3 32 32 32l144 0 0 144c0 17.7 14.3 32 32 32s32-14.3 32-32l0-144 144 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-144 0 0-144z" />
                                        </svg>
                                    </span>
                                    <span class="label-text">Add</span>
                                </button>
                            </div>
                        </div>
                        <div class="task-container" id="task-dropzone" data-category-id="{{ $category->id }}"
                            ondrop="drop({{ $category->id }})" ondragover="event.preventDefault()">
                            @foreach ($tasks as $task)
                                @if ($task->category == $category->id)
                                    <div class="task-item" draggable="true"
                                        ondragstart="onDragStart({{ $task }})"
                                        ondragend="event.preventDefault()">
                                        <div class="task-title">
                                            {{ $task->name }}
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </li>
                @endforeach
            </ul>

        </div>
    </div>

    <script>
        let currentTask;

        function onDragStart(task) {
            currentTask = task;
        }

        const drop = async (category) => {
            if (category !== currentTask.category) {
                let updatedTask = {
                    ...currentTask,
                    category: category
                }

                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                let formData = new FormData();
                for (const key in updatedTask) {
                    if (updatedTask.hasOwnProperty(key)) {
                        formData.append(key, updatedTask[key])
                    }
                }
                try {
                    let res = await fetch(`{{ route('task.update', '') }}/${updatedTask.id}`, {
                        method: 'PUT',
                        body: JSON.stringify(updatedTask),
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        }
                    })
                    if (!res.ok) throw new Error("Network error");
                    let data = await res.json();
                    if (data.success) {
                        window.location.href = "{{ route('task.index') }}";
                    }
                } catch (err) {
                    console.error(err)
                }
            }
        }

        function onDragOver(e) {
            e.preventDefault();
        }

        function onDragEnd(item) {
            // console.log(currentTask)
        }
    </script>

</body>

</html>
