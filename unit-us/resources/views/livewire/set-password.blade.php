<div class="space-y-4">
    <div>
        <label class="mb-2 text-sm text-slate-900 font-medium block">Email</label>
        <div class="relative flex items-center">
            <input type="email" wire:model.blur="email" placeholder="Enter Email"
                class="px-4 py-3 pr-10 bg-[#f0f1f2] focus:bg-transparent w-full text-sm border @error('email') border-red-500 @else border-gray-200 @enderror focus:border-black outline-0 rounded-md transition-all" />
            <svg xmlns="http://www.w3.org/2000/svg" fill="#bbb" stroke="#bbb" class="w-[18px] h-[18px] absolute right-4" viewBox="0 0 682.667 682.667">
                <defs>
                    <clipPath id="a" clipPathUnits="userSpaceOnUse">
                        <path d="M0 512h512V0H0Z"></path>
                    </clipPath>
                </defs>
                <g clip-path="url(#a)" transform="matrix(1.33 0 0 -1.33 0 682.667)">
                    <path fill="none" stroke-miterlimit="10" stroke-width="40" d="M452 444H60c-22.091 0-40-17.909-40-40v-39.446l212.127-157.782c14.17-10.54 33.576-10.54 47.746 0L492 364.554V404c0 22.091-17.909 40-40 40Z"></path>
                    <path d="M472 274.9V107.999c0-11.027-8.972-20-20-20H60c-11.028 0-20 8.973-20 20V274.9L0 304.652V107.999c0-33.084 26.916-60 60-60h392c33.084 0 60 26.916 60 60v196.653Z"></path>
                </g>
            </svg>
        </div>
        @error('email') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
    </div>

    <div>
        <label class="mb-2 text-sm text-slate-900 font-medium block">Temporary Password</label>
        <div class="relative flex items-center">
            <input id="temp_password" type="password" wire:model.blur="temp_password" placeholder="Enter Temporary Password"
                class="px-4 py-3 pr-10 bg-[#f0f1f2] focus:bg-transparent w-full text-sm border @error('temp_password') border-red-500 @else border-gray-200 @enderror focus:border-black outline-0 rounded-md transition-all" />
            <svg onclick="togglePassword('temp_password')" xmlns="http://www.w3.org/2000/svg" fill="#bbb" stroke="#bbb" class="w-[18px] h-[18px] absolute right-4 cursor-pointer" viewBox="0 0 128 128">
                <path d="M64 104C22.127 104 1.367 67.496.504 65.943a4 4 0 0 1 0-3.887C1.367 60.504 22.127 24 64 24s62.633 36.504 63.496 38.057a4 4 0 0 1 0 3.887C126.633 67.496 105.873 104 64 104zM8.707 63.994C13.465 71.205 32.146 96 64 96c31.955 0 50.553-24.775 55.293-31.994C114.535 56.795 95.854 32 64 32 32.045 32 13.447 56.775 8.707 63.994zM64 88c-13.234 0-24-10.766-24-24s10.766-24 24-24 24 10.766 24 24-10.766 24-24 24zm0-40c-8.822 0-16 7.178-16 16s7.178 16 16 16 16-7.178 16-16-7.178-16-16-16z"></path>
            </svg>
        </div>
        @error('temp_password') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
    </div>

    <div>
        <label class="mb-2 text-sm text-slate-900 font-medium block">New Password</label>
        <div class="relative flex items-center">
            <input id="new_password" type="password" wire:model.blur="new_password" placeholder="Enter New Password"
                class="px-4 py-3 pr-10 bg-[#f0f1f2] focus:bg-transparent w-full text-sm border @error('new_password') border-red-500 @else border-gray-200 @enderror focus:border-black outline-0 rounded-md transition-all" />
            <svg onclick="togglePassword('new_password')" xmlns="http://www.w3.org/2000/svg" fill="#bbb" stroke="#bbb" class="w-[18px] h-[18px] absolute right-4 cursor-pointer" viewBox="0 0 128 128">
                <path d="M64 104C22.127 104 1.367 67.496.504 65.943a4 4 0 0 1 0-3.887C1.367 60.504 22.127 24 64 24s62.633 36.504 63.496 38.057a4 4 0 0 1 0 3.887C126.633 67.496 105.873 104 64 104zM8.707 63.994C13.465 71.205 32.146 96 64 96c31.955 0 50.553-24.775 55.293-31.994C114.535 56.795 95.854 32 64 32 32.045 32 13.447 56.775 8.707 63.994zM64 88c-13.234 0-24-10.766-24-24s10.766-24 24-24 24 10.766 24 24-10.766 24-24 24zm0-40c-8.822 0-16 7.178-16 16s7.178 16 16 16 16-7.178 16-16-7.178-16-16-16z"></path>
            </svg>
        </div>
        @error('new_password') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
    </div>

    <div>
        <label class="mb-2 text-sm text-slate-900 font-medium block">Confirm New Password</label>
        <div class="relative flex items-center">
            <input id="new_password_confirmation" type="password" wire:model.blur="new_password_confirmation" placeholder="Confirm New Password"
                class="px-4 py-3 pr-10 bg-[#f0f1f2] focus:bg-transparent w-full text-sm border border-gray-200 focus:border-black outline-0 rounded-md transition-all" />
            <svg onclick="togglePassword('new_password_confirmation')" xmlns="http://www.w3.org/2000/svg" fill="#bbb" stroke="#bbb" class="w-[18px] h-[18px] absolute right-4 cursor-pointer" viewBox="0 0 128 128">
                <path d="M64 104C22.127 104 1.367 67.496.504 65.943a4 4 0 0 1 0-3.887C1.367 60.504 22.127 24 64 24s62.633 36.504 63.496 38.057a4 4 0 0 1 0 3.887C126.633 67.496 105.873 104 64 104zM8.707 63.994C13.465 71.205 32.146 96 64 96c31.955 0 50.553-24.775 55.293-31.994C114.535 56.795 95.854 32 64 32 32.045 32 13.447 56.775 8.707 63.994zM64 88c-13.234 0-24-10.766-24-24s10.766-24 24-24 24 10.766 24 24-10.766 24-24 24zm0-40c-8.822 0-16 7.178-16 16s7.178 16 16 16 16-7.178 16-16-7.178-16-16-16z"></path>
            </svg>
        </div>
    </div>

    <button wire:click="submit" type="button" class="px-5 py-2.5 w-full cursor-pointer !mt-6 text-[15px] font-medium bg-black hover:bg-[#111] text-white rounded-md">Set Password</button>
</div>
