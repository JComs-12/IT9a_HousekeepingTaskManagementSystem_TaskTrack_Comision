<x-app-layout>
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="fw-bold">
                    <i class="fas fa-plus me-2" style="color: #e94560;"></i>
                    Add New Task
                </h2>
                <p class="text-muted">Fill in the details to assign a new task</p>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-tasks me-2"></i>Task Details
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('admin.tasks.store') }}" method="POST">
                            @csrf

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Task Name(s)</label>
                                    <input type="hidden" name="task_name" id="task_name_hidden" value="{{ old('task_name') }}">
                                    <div class="dropdown">
                                        <button class="btn dropdown-toggle w-100 text-start d-flex justify-content-between align-items-center form-control @error('task_name') is-invalid @enderror" 
                                                type="button" 
                                                id="taskDropdownMenu" 
                                                data-bs-toggle="dropdown" 
                                                data-bs-auto-close="outside"
                                                aria-expanded="false"
                                                style="background-color: #0f3460; border-color: #1a4a8a; color: #ffffff;">
                                            <span id="selectedTasksText">Select Tasks...</span>
                                        </button>
                                        <div class="dropdown-menu w-100 p-2 shadow" aria-labelledby="taskDropdownMenu" style="background-color: #16213e; border: 1px solid #0f3460;">
                                            <div class="input-group mb-2">
                                                <input type="text" id="newTaskInput" class="form-control form-control-sm" placeholder="Add custom task..." style="background-color: #0f3460; border-color: #1a4a8a; color: #ffffff;">
                                                <button class="btn btn-sm btn-primary" type="button" id="addNewTaskBtn"><i class="fas fa-plus"></i></button>
                                            </div>
                                            <ul id="taskListContainer" class="list-unstyled mb-0" style="max-height: 200px; overflow-y: auto;">
                                                <!-- Tasks injected via JS -->
                                            </ul>
                                        </div>
                                    </div>
                                    @error('task_name')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Assign Room</label>
                                    <select name="room_id"
                                            class="form-select @error('room_id') is-invalid @enderror">
                                        <option value="">-- Select Room --</option>
                                        @foreach($rooms as $room)
                                            <option value="{{ $room->id }}" {{ old('room_id') == $room->id ? 'selected' : '' }}>
                                                Room {{ $room->room_number }} - {{ $room->room_type }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('room_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Assign Staff</label>
                                    <div class="dropdown">
                                        <button class="btn dropdown-toggle w-100 text-start d-flex justify-content-between align-items-center form-control @error('staff_ids') is-invalid @enderror" 
                                                type="button" 
                                                id="staffDropdownMenu" 
                                                data-bs-toggle="dropdown" 
                                                data-bs-auto-close="outside"
                                                aria-expanded="false"
                                                style="background-color: #0f3460; border-color: #1a4a8a; color: #ffffff; overflow: hidden;">
                                            <span id="selectedStaffText" style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap; flex: 1;">Select Staff Members...</span>
                                        </button>
                                        <ul class="dropdown-menu w-100 p-2 shadow" aria-labelledby="staffDropdownMenu" style="max-height: 300px; overflow-y: auto;">
                                            @foreach($staff as $member)
                                                <li class="dropdown-item px-2" style="background: transparent;">
                                                    <div class="form-check m-0">
                                                        <input class="form-check-input staff-checkbox" type="checkbox" name="staff_ids[]" value="{{ $member->id }}" id="staff_{{ $member->id }}" {{ in_array($member->id, old('staff_ids', [])) ? 'checked' : '' }} data-name="{{ $member->name }}" style="cursor: pointer;">
                                                        <label class="form-check-label w-100" for="staff_{{ $member->id }}" style="cursor: pointer; color: #ffffff;">
                                                            {{ $member->name }}
                                                        </label>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @error('staff_ids')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Priority</label>
                                    <select name="priority"
                                            class="form-select @error('priority') is-invalid @enderror">
                                        <option value="">-- Select Priority --</option>
                                        <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Low</option>
                                        <option value="medium" {{ old('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
                                        <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>High</option>
                                    </select>
                                    @error('priority')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Due Date</label>
                                    <input type="date"
                                           name="due_date"
                                           class="form-control @error('due_date') is-invalid @enderror"
                                           value="{{ old('due_date') }}">
                                    @error('due_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Status</label>
                                    <select name="status"
                                            class="form-select @error('status') is-invalid @enderror">
                                        <option value="">-- Select Status --</option>
                                        <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="in_progress" {{ old('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                        <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12 mb-4">
                                    <label class="form-label fw-bold">Description</label>
                                    <textarea name="description"
                                              class="form-control @error('description') is-invalid @enderror"
                                              rows="3"
                                              placeholder="Enter task description (optional)">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-save me-2"></i>Save Task
                                </button>
                                <a href="{{ route('admin.tasks.index') }}" class="btn btn-secondary w-100">
                                    <i class="fas fa-arrow-left me-2"></i>Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // --- Staff Checkbox Logic ---
            const staffCheckboxes = document.querySelectorAll('.staff-checkbox');
            const staffButtonText = document.getElementById('selectedStaffText');

            function updateStaffButtonText() {
                const selectedNames = Array.from(staffCheckboxes)
                    .filter(cb => cb.checked)
                    .map(cb => cb.dataset.name);
                
                if (selectedNames.length === 0) {
                    staffButtonText.textContent = 'Select Staff Members...';
                } else if (selectedNames.length <= 2) {
                    staffButtonText.textContent = selectedNames.join(', ');
                } else {
                    staffButtonText.textContent = selectedNames.length + ' staff selected';
                }
            }

            staffCheckboxes.forEach(cb => {
                cb.addEventListener('change', updateStaffButtonText);
            });
            updateStaffButtonText();

            // --- Task Checkbox Logic ---
            const taskListContainer = document.getElementById('taskListContainer');
            const newTaskInput = document.getElementById('newTaskInput');
            const addNewTaskBtn = document.getElementById('addNewTaskBtn');
            const selectedTasksText = document.getElementById('selectedTasksText');
            const taskNameHidden = document.getElementById('task_name_hidden');

            const defaultTasks = ['Clean Bedroom', 'Clean Toilet', 'Change Bed Sheets', 'Refill Amenities'];
            let savedTasks = JSON.parse(localStorage.getItem('predefined_tasks')) || defaultTasks;
            let assignedTasks = taskNameHidden.value ? taskNameHidden.value.split(',').map(t => t.trim()).filter(t => t) : [];

            // Add assigned tasks to saved tasks if they are custom
            assignedTasks.forEach(task => {
                if (!savedTasks.includes(task)) savedTasks.push(task);
            });

            function renderTasks() {
                taskListContainer.innerHTML = '';
                savedTasks.forEach((task, index) => {
                    const isChecked = assignedTasks.includes(task) ? 'checked' : '';
                    const li = document.createElement('li');
                    li.className = 'dropdown-item px-2 d-flex justify-content-between align-items-center mb-1';
                    li.style.background = 'transparent';
                    li.innerHTML = `
                        <div class="form-check m-0 text-truncate" style="max-width: 85%;">
                            <input class="form-check-input task-checkbox" type="checkbox" value="${task.replace(/"/g, '&quot;')}" id="task_${index}" ${isChecked} style="cursor: pointer;">
                            <label class="form-check-label text-white" for="task_${index}" style="cursor: pointer;">
                                ${task}
                            </label>
                        </div>
                        <button type="button" class="btn btn-sm text-danger p-0 ms-2 delete-task-btn" data-index="${index}" title="Remove task">
                            <i class="fas fa-times"></i>
                        </button>
                    `;
                    taskListContainer.appendChild(li);
                });

                document.querySelectorAll('.task-checkbox').forEach(cb => {
                    cb.addEventListener('change', updateHiddenTaskInput);
                });

                document.querySelectorAll('.delete-task-btn').forEach(btn => {
                    btn.addEventListener('click', function(e) {
                        e.stopPropagation(); // prevent dropdown from closing
                        const idx = this.getAttribute('data-index');
                        const taskToRemove = savedTasks[idx];
                        savedTasks.splice(idx, 1);
                        localStorage.setItem('predefined_tasks', JSON.stringify(savedTasks));
                        assignedTasks = assignedTasks.filter(t => t !== taskToRemove);
                        updateHiddenTaskInput();
                        renderTasks();
                    });
                });
                
                updateHiddenTaskInput();
            }

            function updateHiddenTaskInput() {
                const checkedBoxes = document.querySelectorAll('.task-checkbox:checked');
                assignedTasks = Array.from(checkedBoxes).map(cb => cb.value);
                taskNameHidden.value = assignedTasks.join(', ');

                if (assignedTasks.length === 0) {
                    selectedTasksText.textContent = 'Select Tasks...';
                } else if (assignedTasks.length <= 2) {
                    selectedTasksText.textContent = assignedTasks.join(', ');
                } else {
                    selectedTasksText.textContent = assignedTasks.length + ' tasks selected';
                }
            }

            addNewTaskBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                const newTask = newTaskInput.value.trim();
                if (newTask && !savedTasks.includes(newTask)) {
                    savedTasks.push(newTask);
                    localStorage.setItem('predefined_tasks', JSON.stringify(savedTasks));
                    assignedTasks.push(newTask);
                    newTaskInput.value = '';
                    renderTasks();
                }
            });

            newTaskInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    addNewTaskBtn.click();
                }
            });

            renderTasks();
        });
    </script>
</x-app-layout>