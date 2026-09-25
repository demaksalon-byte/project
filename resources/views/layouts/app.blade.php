<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JAYMARK</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-primary);
            color: var(--text-primary);
            transition: background-color 0.25s ease, color 0.25s ease;
        }

        :root {
            --bg-primary: #f8fafc;
            --bg-secondary: #ffffff;
            --bg-card: #ffffff;
            --border-color: #e2e8f0;
            --border-hover: #cbd5e1;
            --text-primary: #0f172a;
            --text-secondary: #64748b;
            --accent: #0f172a;
            --accent-text: #ffffff;
            --shadow-card: 0 4px 6px -1px rgb(0 0 0 / 0.02), 0 2px 4px -2px rgb(0 0 0 / 0.02);
        }

        .dark {
            --bg-primary: #09090b;
            --bg-secondary: #121215;
            --bg-card: #18181b;
            --border-color: #27272a;
            --border-hover: #3f3f46;
            --text-primary: #f4f4f5;
            --text-secondary: #a1a1aa;
            --accent: #f4f4f5;
            --accent-text: #09090b;
            --shadow-card: 0 4px 6px -1px rgb(0 0 0 / 0.2);
        }

        .clean-card {
            background-color: var(--bg-card);
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-card);
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .clean-card:hover {
            border-color: var(--border-hover);
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.05), 0 4px 6px -4px rgb(0 0 0 / 0.05);
        }

        .clean-input {
            background-color: var(--bg-secondary);
            border: 1px solid var(--border-color);
            color: var(--text-primary);
            transition: all 0.2s ease;
        }
        .clean-input:focus {
            outline: none;
            border-color: var(--text-secondary);
            box-shadow: 0 0 0 3px rgba(100, 116, 139, 0.15);
        }

        .primary-btn {
            background-color: var(--accent);
            color: var(--accent-text);
            transition: all 0.15s ease;
        }
        .primary-btn:hover {
            opacity: 0.9;
            transform: translateY(-1px);
        }

        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: var(--border-color); border-radius: 9999px; }
        ::-webkit-scrollbar-thumb:hover { background: var(--border-hover); }
    </style>
</head>
<body id="appBody" class="min-h-full flex flex-col md:flex-row selection:bg-slate-500 selection:text-white">

    <!-- Main Workspace Container (Centered Content) -->
    <div class="flex-1 flex flex-col min-h-screen">
        
        <!-- Top Bar (Search & Filter Dropdowns) -->
        <header class="border-b border-[var(--border-color)] bg-[var(--bg-secondary)]/80 backdrop-blur-md sticky top-0 z-30 px-6 md:px-10 h-18 flex items-center justify-between gap-4">
            <!-- Global Search Bar -->
            <div class="relative w-full max-w-md">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-[var(--text-secondary)]">
                    <i class="fa-solid fa-magnifying-glass text-[11px]"></i>
                </span>
                <input type="text" id="searchInput" oninput="handleSearch()" placeholder="Search tasks by title or details..." class="w-full clean-input pl-10 pr-4 py-2 rounded-xl text-xs font-medium">
            </div>

            <!-- Secondary Dropdowns -->
            <div class="flex items-center gap-2.5 shrink-0">
                <select id="categoryFilter" onchange="renderTasks()" class="clean-input px-3 py-2 rounded-xl text-xs font-medium">
                    <option value="all">All Categories</option>
                    <option value="Work">Work / School</option>
                    <option value="Personal">Personal</option>
                </select>
                <select id="priorityFilter" onchange="renderTasks()" class="clean-input px-3 py-2 rounded-xl text-xs font-medium">
                    <option value="all">All Priorities</option>
                    <option value="Urgent">Urgent</option>
                    <option value="Reminder">Reminder</option>
                </select>
            </div>
        </header>

        <!-- Main Centered Content Grid -->
        <main class="p-6 md:p-10 flex-1 flex justify-center">
            <div class="max-w-4xl w-full space-y-8">

                <!-- Metrics Overview Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="clean-card rounded-2xl p-5 flex items-center justify-between">
                        <div>
                            <p class="text-[11px] font-semibold text-[var(--text-secondary)] uppercase tracking-wider">Total Tasks</p>
                            <h3 id="statTotal" class="text-2xl font-bold tracking-tight mt-0.5">0</h3>
                        </div>
                        <div class="w-10 h-10 rounded-xl border border-[var(--border-color)] bg-[var(--bg-primary)] flex items-center justify-center text-[var(--text-secondary)]">
                            <i class="fa-solid fa-layer-group text-xs"></i>
                        </div>
                    </div>
                    <div class="clean-card rounded-2xl p-5 flex items-center justify-between">
                        <div>
                            <p class="text-[11px] font-semibold text-[var(--text-secondary)] uppercase tracking-wider">In Progress</p>
                            <h3 id="statPending" class="text-2xl font-bold tracking-tight mt-1 text-blue-600 dark:text-blue-400">0</h3>
                        </div>
                        <div class="w-10 h-10 rounded-xl border border-blue-200 bg-blue-50/50 dark:bg-blue-950/20 flex items-center justify-center text-blue-600 dark:text-blue-400">
                            <i class="fa-solid fa-spinner text-xs"></i>
                        </div>
                    </div>
                    <div class="clean-card rounded-2xl p-5 flex items-center justify-between">
                        <div>
                            <p class="text-[11px] font-semibold text-[var(--text-secondary)] uppercase tracking-wider">Completed</p>
                            <h3 id="statCompleted" class="text-2xl font-bold tracking-tight mt-1 text-emerald-600 dark:text-emerald-400">0</h3>
                        </div>
                        <div class="w-10 h-10 rounded-xl border border-emerald-200 bg-emerald-50/50 dark:bg-emerald-950/20 flex items-center justify-center text-emerald-600 dark:text-emerald-400">
                            <i class="fa-solid fa-check text-xs"></i>
                        </div>
                    </div>
                </div>

                <!-- Task Grid Container -->
                <div>
                    <!-- Empty State -->
                    <div id="emptyState" class="hidden py-20 text-center clean-card rounded-2xl">
                        <div class="w-12 h-12 mx-auto mb-3 rounded-xl border border-[var(--border-color)] bg-[var(--bg-primary)] flex items-center justify-center text-[var(--text-secondary)] text-sm">
                            <i class="fa-regular fa-clipboard"></i>
                        </div>
                        <h3 class="font-semibold text-xs uppercase tracking-wider">No tasks found</h3>
                        <p class="text-xs text-[var(--text-secondary)] font-medium mt-1">Get started by creating a new task.</p>
                    </div>

                    <!-- Grid -->
                    <div id="taskGrid" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Injected dynamically -->
                    </div>
                </div>

            </div>
        </main>
    </div>

    <!-- Right Sidebar Layout -->
    <aside class="w-full md:w-64 border-t md:border-t-0 md:border-l border-[var(--border-color)] bg-[var(--bg-secondary)] flex flex-col justify-between p-6 shrink-0 md:min-h-screen sticky top-0 z-40 order-first md:order-last">
        <div>
            <!-- Logo / App Identity -->
            <div class="flex items-center gap-3.5 mb-8">
                <div class="w-10 h-10 rounded-xl bg-[var(--accent)] text-[var(--accent-text)] flex items-center justify-center font-bold text-sm shadow-sm">
                    J
                </div>
                <div>
                    <h1 class="font-bold text-sm tracking-widest uppercase">JAYMARK</h1>
                    <p class="text-[11px] text-[var(--text-secondary)] font-medium tracking-wide">Task Manager</p>
                </div>
            </div>

            <!-- New Task Action -->
            <button onclick="openCreateModal()" class="w-full py-2.5 px-4 rounded-xl text-xs font-semibold tracking-wide flex items-center justify-center gap-2 primary-btn shadow-sm mb-6">
                <i class="fa-solid fa-plus text-[10px]"></i> New Task
            </button>

            <!-- Navigation Links / Status Filters -->
            <div class="space-y-1">
                <p class="text-[10px] font-bold text-[var(--text-secondary)] uppercase tracking-wider mb-2 px-3">Views</p>
                <button onclick="setFilter('all')" id="tab-all" class="w-full flex items-center justify-between px-3 py-2 rounded-xl text-xs font-semibold transition-all bg-[var(--accent)] text-[var(--accent-text)] shadow-sm">
                    <span class="flex items-center gap-2.5"><i class="fa-solid fa-layer-group w-4 text-center"></i> All Tasks</span>
                    <span id="badge-all" class="text-[10px] opacity-80">0</span>
                </button>
                <button onclick="setFilter('pending')" id="tab-pending" class="w-full flex items-center justify-between px-3 py-2 rounded-xl text-xs font-medium text-[var(--text-secondary)] hover:text-[var(--text-primary)] hover:bg-[var(--bg-primary)] transition-all">
                    <span class="flex items-center gap-2.5"><i class="fa-solid fa-spinner w-4 text-center"></i> In Progress</span>
                    <span id="badge-pending" class="text-[10px] opacity-80">0</span>
                </button>
                <button onclick="setFilter('completed')" id="tab-completed" class="w-full flex items-center justify-between px-3 py-2 rounded-xl text-xs font-medium text-[var(--text-secondary)] hover:text-[var(--text-primary)] hover:bg-[var(--bg-primary)] transition-all">
                    <span class="flex items-center gap-2.5"><i class="fa-solid fa-check w-4 text-center"></i> Completed</span>
                    <span id="badge-completed" class="text-[10px] opacity-80">0</span>
                </button>
            </div>
        </div>

        <!-- Sidebar Footer Actions (Theme Toggle) -->
        <div class="pt-6 mt-6 border-t border-[var(--border-color)] flex items-center justify-between">
            <span class="text-xs font-medium text-[var(--text-secondary)]">Dark Mode</span>
            <button onclick="toggleDarkMode()" class="w-9 h-9 rounded-xl clean-input flex items-center justify-center text-xs text-[var(--text-secondary)] hover:text-[var(--text-primary)] transition-colors" title="Toggle Theme">
                <i id="themeIcon" class="fa-solid fa-moon"></i>
            </button>
        </div>
    </aside>

    <!-- Clean Modal Form Overlay -->
    <div id="taskModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40 backdrop-blur-xs hidden opacity-0 transition-opacity duration-200">
        <div class="clean-card bg-[var(--bg-card)] rounded-2xl w-full max-w-md overflow-hidden transform scale-95 transition-transform duration-200 shadow-2xl" id="modalCard">
            <div class="flex items-center justify-between px-6 py-4 border-b border-[var(--border-color)]">
                <h3 id="modalTitle" class="font-bold text-xs tracking-wider uppercase">Create New Task</h3>
                <button onclick="closeModal()" class="w-7 h-7 rounded-lg clean-input flex items-center justify-center text-[var(--text-secondary)] hover:text-[var(--text-primary)] transition-colors">
                    <i class="fa-solid fa-xmark text-xs"></i>
                </button>
            </div>
            <form id="taskForm" onsubmit="handleFormSubmit(event)" class="p-6 space-y-4">
                <input type="hidden" id="taskId">
                <div>
                    <label class="block text-[11px] font-semibold text-[var(--text-secondary)] mb-1.5 uppercase tracking-wider">Title *</label>
                    <input type="text" id="taskTitle" required placeholder="e.g., Prepare quarterly review..." class="w-full clean-input px-3.5 py-2.5 rounded-xl text-xs font-medium">
                </div>
                <div>
                    <label class="block text-[11px] font-semibold text-[var(--text-secondary)] mb-1.5 uppercase tracking-wider">Description</label>
                    <textarea id="taskDesc" rows="3" placeholder="Add optional details..." class="w-full clean-input px-3.5 py-2.5 rounded-xl text-xs font-medium resize-none"></textarea>
                </div>
                <div class="grid grid-cols-3 gap-3">
                    <div>
                        <label class="block text-[11px] font-semibold text-[var(--text-secondary)] mb-1.5 uppercase tracking-wider">Category</label>
                        <select id="taskCategory" class="w-full clean-input px-3 py-2 rounded-xl text-xs font-medium">
                            <option value="Work">Work</option>
                            <option value="Personal">Personal</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-[var(--text-secondary)] mb-1.5 uppercase tracking-wider">Priority</label>
                        <select id="taskPriority" class="w-full clean-input px-3 py-2 rounded-xl text-xs font-medium">
                            <option value="Reminder">Reminder</option>
                            <option value="Urgent">Urgent</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-[var(--text-secondary)] mb-1.5 uppercase tracking-wider">Deadline *</label>
                        <input type="date" id="taskDueDate" required class="w-full clean-input px-2 py-2 rounded-xl text-[11px] font-medium">
                    </div>
                </div>
                <div class="pt-4 border-t border-[var(--border-color)] flex items-center justify-end gap-2.5">
                    <button type="button" onclick="closeModal()" class="px-4 py-2 rounded-xl clean-input text-xs font-semibold uppercase hover:border-[var(--border-hover)] transition-colors">Cancel</button>
                    <button type="submit" class="px-5 py-2 rounded-xl text-xs font-semibold uppercase primary-btn shadow-sm">Save Task</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Application Engine Script -->
    <script>
        let tasks = [];
        let currentFilter = 'all';
        let currentSearchQuery = '';

        window.onload = function() {
            document.getElementById('taskDueDate').min = new Date().toISOString().split('T')[0];
            renderApp();
        };

        function toggleDarkMode() {
            const body = document.getElementById('appBody');
            const icon = document.getElementById('themeIcon');
            if (body.classList.contains('dark')) {
                body.classList.remove('dark');
                icon.className = "fa-solid fa-moon";
            } else {
                body.classList.add('dark');
                icon.className = "fa-solid fa-sun";
            }
        }

        function setFilter(filter) {
            currentFilter = filter;
            ['all', 'pending', 'completed'].forEach(f => {
                const btn = document.getElementById(`tab-${f}`);
                if (f === filter) {
                    btn.className = "w-full flex items-center justify-between px-3 py-2 rounded-xl text-xs font-semibold transition-all bg-[var(--accent)] text-[var(--accent-text)] shadow-sm";
                } else {
                    btn.className = "w-full flex items-center justify-between px-3 py-2 rounded-xl text-xs font-medium text-[var(--text-secondary)] hover:text-[var(--text-primary)] hover:bg-[var(--bg-primary)] transition-all";
                }
            });
            renderTasks();
        }

        function handleSearch() {
            currentSearchQuery = document.getElementById('searchInput').value.toLowerCase().trim();
            renderTasks();
        }

        function renderApp() {
            updateStats();
            renderTasks();
        }

        function updateStats() {
            const total = tasks.length;
            const pending = tasks.filter(t => t.status === 'pending').length;
            const completed = tasks.filter(t => t.status === 'completed').length;

            document.getElementById('statTotal').innerText = total;
            document.getElementById('statPending').innerText = pending;
            document.getElementById('statCompleted').innerText = completed;

            document.getElementById('badge-all').innerText = total;
            document.getElementById('badge-pending').innerText = pending;
            document.getElementById('badge-completed').innerText = completed;
        }

        function renderTasks() {
            const categoryVal = document.getElementById('categoryFilter').value;
            const priorityVal = document.getElementById('priorityFilter').value;

            const filtered = tasks.filter(t => {
                if (currentFilter !== 'all' && t.status !== currentFilter) return false;
                if (categoryVal !== 'all' && t.category !== categoryVal) return false;
                if (priorityVal !== 'all' && t.priority !== priorityVal) return false;
                if (currentSearchQuery && !t.title.toLowerCase().includes(currentSearchQuery) && !t.description.toLowerCase().includes(currentSearchQuery)) return false;
                return true;
            });

            const grid = document.getElementById('taskGrid');
            const emptyState = document.getElementById('emptyState');
            grid.innerHTML = '';

            if (filtered.length === 0) {
                emptyState.classList.remove('hidden');
                grid.classList.add('hidden');
                return;
            } else {
                emptyState.classList.add('hidden');
                grid.classList.remove('hidden');
            }

            filtered.forEach(task => {
                const isCompleted = task.status === 'completed';
                const card = document.createElement('div');
                card.className = "clean-card rounded-2xl p-5 flex flex-col justify-between";
                card.innerHTML = `
                    <div>
                        <div class="flex items-center justify-between gap-2 mb-3">
                            <div class="flex items-center gap-1.5">
                                <span class="px-2 py-0.5 rounded-md text-[10px] font-semibold uppercase border border-[var(--border-color)] bg-[var(--bg-primary)] text-[var(--text-secondary)]">${task.category}</span>
                                <span class="px-2 py-0.5 rounded-md text-[10px] font-semibold uppercase border ${task.priority === 'Urgent' ? 'border-rose-200 bg-rose-50 text-rose-600 dark:bg-rose-950/30 dark:text-rose-400' : 'border-amber-200 bg-amber-50 text-amber-600 dark:bg-amber-950/30 dark:text-amber-400'}">${task.priority}</span>
                            </div>
                            <span class="text-[10px] font-medium text-[var(--text-secondary)]"><i class="fa-regular fa-calendar mr-1"></i>${task.dueDate}</span>
                        </div>
                        <h4 class="font-semibold text-xs tracking-tight mb-1.5 ${isCompleted ? 'line-through opacity-50' : ''}">${escapeHtml(task.title)}</h4>
                        <p class="text-xs text-[var(--text-secondary)] font-normal line-clamp-2 leading-relaxed">${escapeHtml(task.description || 'No additional details provided.')}</p>
                    </div>
                    <div class="mt-5 pt-3 border-t border-[var(--border-color)] flex items-center justify-between">
                        <span class="inline-flex items-center gap-1.5 text-[10px] font-semibold uppercase tracking-wide ${isCompleted ? 'text-emerald-600 dark:text-emerald-400' : 'text-blue-600 dark:text-blue-400'}">
                            <span class="w-1.5 h-1.5 rounded-full ${isCompleted ? 'bg-emerald-600 dark:bg-emerald-400' : 'bg-blue-600 dark:bg-blue-400'}"></span>
                            ${isCompleted ? 'Completed' : 'In Progress'}
                        </span>
                        <div class="flex items-center gap-1">
                            <button onclick="toggleStatus('${task.id}')" title="${isCompleted ? 'Reopen' : 'Complete'}" class="w-7 h-7 rounded-lg clean-input flex items-center justify-center text-xs hover:border-[var(--border-hover)] transition-colors">
                                <i class="fa-solid ${isCompleted ? 'fa-rotate-left' : 'fa-check'} text-[11px]"></i>
                            </button>
                            <button onclick="openEditModal('${task.id}')" title="Edit" class="w-7 h-7 rounded-lg clean-input flex items-center justify-center text-xs hover:border-[var(--border-hover)] transition-colors">
                                <i class="fa-solid fa-pen text-[10px]"></i>
                            </button>
                            <button onclick="deleteTask('${task.id}')" title="Delete" class="w-7 h-7 rounded-lg clean-input flex items-center justify-center text-xs hover:text-rose-600 hover:border-rose-300 transition-colors">
                                <i class="fa-solid fa-trash-can text-[10px]"></i>
                            </button>
                        </div>
                    </div>
                `;
                grid.appendChild(card);
            });
            updateStats();
        }

        function openModal() {
            const modal = document.getElementById('taskModal');
            const card = document.getElementById('modalCard');
            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                card.classList.remove('scale-95');
                card.classList.add('scale-100');
            }, 10);
        }

        function openCreateModal() {
            document.getElementById('taskId').value = '';
            document.getElementById('taskForm').reset();
            document.getElementById('modalTitle').innerText = 'Create New Task';
            openModal();
        }

        function openEditModal(id) {
            const task = tasks.find(t => t.id === id);
            if (!task) return;
            document.getElementById('taskId').value = task.id;
            document.getElementById('taskTitle').value = task.title;
            document.getElementById('taskDesc').value = task.description;
            document.getElementById('taskCategory').value = task.category;
            document.getElementById('taskPriority').value = task.priority;
            document.getElementById('taskDueDate').value = task.dueDate;
            document.getElementById('modalTitle').innerText = 'Edit Task';
            openModal();
        }

        function closeModal() {
            const modal = document.getElementById('taskModal');
            const card = document.getElementById('modalCard');
            modal.classList.add('opacity-0');
            card.classList.remove('scale-100');
            card.classList.add('scale-95');
            setTimeout(() => modal.classList.add('hidden'), 200);
        }

        function handleFormSubmit(e) {
            e.preventDefault();
            const id = document.getElementById('taskId').value;
            const title = document.getElementById('taskTitle').value.trim();
            const description = document.getElementById('taskDesc').value.trim();
            const category = document.getElementById('taskCategory').value;
            const priority = document.getElementById('taskPriority').value;
            const dueDate = document.getElementById('taskDueDate').value;

            if (!title || !dueDate) return;

            if (id) {
                tasks = tasks.map(t => t.id === id ? { ...t, title, description, category, priority, dueDate } : t);
            } else {
                tasks.unshift({
                    id: Date.now().toString(),
                    title, description, category, priority, dueDate,
                    status: 'pending'
                });
            }
            closeModal();
            renderApp();
        }

        function toggleStatus(id) {
            tasks = tasks.map(t => t.id === id ? { ...t, status: t.status === 'completed' ? 'pending' : 'completed' } : t);
            renderApp();
        }

        function deleteTask(id) {
            tasks = tasks.filter(t => t.id !== id);
            renderApp();
        }

        function escapeHtml(str) {
            return str.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;").replace(/'/g, "&#039;");
        }
    </script>
</body>
</html>