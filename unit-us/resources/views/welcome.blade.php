<!DOCTYPE html>
<html>
<head>
    <title>Welcome - Set Your Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @livewireStyles
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-md">
            <h2 class="text-2xl font-bold text-center mb-6 text-slate-900">Welcome! Set Your New Password</h2>
            
            <livewire:set-password :slug="$slug" />
        </div>
    </div>
    
    @livewireScripts
    <script>
        function togglePassword(id) {
            const input = document.getElementById(id);
            input.type = input.type === 'password' ? 'text' : 'password';
        }
    </script>
</body>
</html>
