@foreach ($users as $user)
    <div id="userUpdateModal-{{ $user->id }}"
        class="fixed flex justify-center items-center inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center sm:block sm:p-0">
            <!-- Backdrop -->
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div id="userUpdateBackdrop-{{ $user->id }}"
                    class="absolute inset-0 bg-gray-900/70 backdrop-blur-sm opacity-0 transition-opacity duration-300">
                </div>
            </div>

            <!-- Modal Panel -->
            <div id="userUpdatePanel-{{ $user->id }}"
                class="rounded-2xl overflow-hidden shadow-xl transform transition-all sm:max-w-2xl w-full opacity-0 translate-y-4 scale-95"
                role="dialog" aria-modal="true" aria-labelledby="modal-headline">

                <div class="bg-white dark:bg-gray-800 px-6 pt-6 pb-4 sm:p-6 max-h-[90vh] overflow-y-auto">
                    <!-- Header -->
                    <div class="flex items-start justify-between mb-6">
                        <div class="flex items-start gap-4">
                            <div
                                class="p-3 rounded-xl bg-gradient-to-tr from-indigo-500 to-indigo-600 text-white shadow-lg">
                                <i class="ri-user-settings-line text-2xl"></i>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Update Pengguna</h3>
                                <p class="text-indigo-600 dark:text-indigo-400 text-lg mt-1">Perbarui informasi pengguna
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Form -->
            <form class="ajax-form" data-success="User updated successfully" action="{{ route('superAdmin.users.update', $user->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 gap-6">
                            <!-- Name & Email -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Name -->
                                <div class="relative group">
                                    <div
                                        class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-indigo-500 dark:text-indigo-400">
                                        <i class="ri-user-3-line text-xl"></i>
                                    </div>
                                    <input type="text" id="userName-{{ $user->id }}" name="name"
                                        class="w-full px-5 py-4 pl-14 pr-4 text-lg rounded-xl border-2 border-gray-200 dark:border-gray-600 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100 transition-all duration-300 shadow-sm peer outline-none"
                                        placeholder=" " value="{{ old('name', $user->name) }}" required>
                                    <label for="userName-{{ $user->id }}"
                                        class="absolute left-14 top-4 px-1 text-gray-500 dark:text-gray-400 text-base transition-all duration-300 transform -translate-y-9 scale-90 bg-white dark:bg-gray-700 rounded peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-9 peer-focus:scale-90 peer-focus:text-indigo-600 dark:peer-focus:text-indigo-400 font-medium">
                                        Nama Lengkap
                                    </label>
                                </div>

                                <!-- Email -->
                                <div class="relative group">
                                    <div
                                        class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-indigo-500 dark:text-indigo-400">
                                        <i class="ri-mail-line text-xl"></i>
                                    </div>
                                    <input type="email" id="userEmail-{{ $user->id }}" name="email"
                                        class="w-full px-5 py-4 pl-14 pr-4 text-lg rounded-xl border-2 border-gray-200 dark:border-gray-600 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100 transition-all duration-300 shadow-sm peer outline-none"
                                        placeholder=" " value="{{ old('email', $user->email) }}" required>
                                    <label for="userEmail-{{ $user->id }}"
                                        class="absolute left-14 top-4 px-1 text-gray-500 dark:text-gray-400 text-base transition-all duration-300 transform -translate-y-9 scale-90 bg-white dark:bg-gray-700 rounded peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-9 peer-focus:scale-90 peer-focus:text-indigo-600 dark:peer-focus:text-indigo-400 font-medium">
                                        Email
                                    </label>
                                </div>
                            </div>

                            <!-- Password -->
                            <div class="relative group">
                                <div
                                    class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-indigo-500 dark:text-indigo-400">
                                    <i class="ri-lock-password-line text-xl"></i>
                                </div>
                                <input type="password" id="userPassword-{{ $user->id }}" name="password"
                                    class="w-full px-5 py-4 pl-14 pr-4 text-lg rounded-xl border-2 border-gray-200 dark:border-gray-600
               focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 bg-white dark:bg-gray-700
               text-gray-800 dark:text-gray-100 transition-all duration-300 shadow-sm peer outline-none"
                                    placeholder=" ">
                                <label for="userPassword-{{ $user->id }}"
                                    class="absolute left-14 top-4 px-1 text-gray-500 dark:text-gray-400 text-base transition-all duration-300 transform
               -translate-y-9 scale-90 bg-white dark:bg-gray-700 rounded
               peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0
               peer-focus:-translate-y-9 peer-focus:scale-90 peer-focus:text-indigo-600 dark:peer-focus:text-indigo-400
               font-medium">
                                    Password (kosongkan jika tidak diganti)
                                </label>
                            </div>

                            <!-- Role -->
                            <div class="relative group">
                                <div
                                    class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-indigo-500 dark:text-indigo-400">
                                    <i class="ri-shield-user-line text-xl"></i>
                                </div>
                                <select id="userRole-{{ $user->id }}" name="role"
                                    class="w-full px-5 py-4 pl-14 pr-10 text-lg rounded-xl border-2 border-gray-200 dark:border-gray-600
               focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 bg-white dark:bg-gray-700
               text-gray-800 dark:text-gray-100 transition-all duration-300 shadow-sm appearance-none outline-none">
                                    <option value="superadmin" @selected($user->role === 'superadmin')>Superadmin</option>
                                    <option value="admin" @selected($user->role === 'admin')>Admin</option>
                                    <option value="customer" @selected($user->role === 'customer')>Customer</option>
                                </select>
                                <label for="userRole-{{ $user->id }}"
                                    class="absolute left-14 top-4 px-1 text-gray-500 dark:text-gray-400 text-base transition-all duration-300 transform
               -translate-y-9 scale-90 bg-white dark:bg-gray-700 rounded
               peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0
               peer-focus:-translate-y-9 peer-focus:scale-90 peer-focus:text-indigo-600 dark:peer-focus:text-indigo-400
               font-medium">
                                    Role
                                </label>
                                <div
                                    class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-gray-400">
                                    <i class="ri-arrow-down-s-line text-xl"></i>
                                </div>
                            </div>


                            <!-- Foto Profil -->
                            <div class="relative mt-4">
                                    <label class="block text-gray-700 dark:text-gray-400 text-base font-medium mb-2">User Image</label>
                                    <div id="upload-container-{{ $user->id }}" class="group">
                                        <div id="default-state-{{ $user->id }}"
                                            class="{{ $user->profile_picture ? 'hidden' : 'flex' }} flex-col items-center justify-center border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-xl p-8 text-center cursor-pointer transition-all duration-300 hover:border-indigo-400 hover:bg-indigo-50/30 dark:hover:bg-indigo-900/30">
                                            <i class="ri-upload-cloud-2-line text-4xl text-indigo-500 dark:text-indigo-400 mb-3"></i>
                                            <p class="font-semibold text-gray-700 dark:text-gray-200">Upload Image</p>
                                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">PNG, JPG, GIF up to 10MB</p>
                                        </div>

                                        <div id="preview-state-{{ $user->id }}"
                                            class="{{ $user->profile_picture ? 'block' : 'hidden' }} relative w-full h-64 rounded-xl overflow-hidden border-2 border-gray-200 dark:border-gray-700">
                                            <img id="preview-image-{{ $user->id }}" class="w-full h-full object-cover"
                                                src="{{ $user->profile_picture ? asset($user->profile_picture) : '' }}" alt="Image Preview">
                                            <div class="absolute inset-0 bg-black/0 hover:bg-black/20 transition-all duration-300 flex items-center justify-center opacity-0 hover:opacity-100">
                                                <button type="button" id="change-image-{{ $user->id }}"
                                                    class="bg-white dark:bg-gray-800 text-indigo-600 dark:text-indigo-400 px-4 py-2 rounded-lg shadow-md font-medium hover:bg-indigo-50 dark:hover:bg-indigo-700 transition cursor-pointer">
                                                    Change Image
                                                </button>
                                            </div>
                                        </div>

                                        <input id="file-upload-{{ $user->id }}" type="file" name="profile_picture" accept="image/*" class="hidden">
                                    </div>
                                </div>
                        </div>

                        <!-- Footer -->
                        <div class="bg-white dark:bg-gray-800 px-1 py-4 flex justify-end rounded-b-xl mt-6">
                            <button type="button" id="cancelUserUpdateModal-{{ $user->id }}"
                                class="mt-3 w-full inline-flex justify-center items-center rounded-xl border border-gray-300 dark:border-gray-600 shadow-sm px-6 py-3 bg-white dark:bg-gray-700 text-base font-semibold text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-800 hover:-translate-y-0.5 transition-all duration-300 sm:mt-0 sm:ml-3 sm:w-auto cursor-pointer">
                                <i class="ri-close-line mr-2"></i> Cancel
                            </button>
                            <button type="submit"
                                class="w-full inline-flex justify-center items-center rounded-xl border border-transparent shadow-sm px-6 py-3 bg-gradient-to-r from-indigo-500 to-indigo-600 text-white text-base font-semibold hover:from-indigo-600 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto transition-all duration-300 transform hover:-translate-y-0.5 hover:shadow-md cursor-pointer">
                                <i class="ri-save-line mr-2"></i> Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach
