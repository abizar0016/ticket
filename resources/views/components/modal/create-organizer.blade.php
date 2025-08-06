<div id="organizerModal" class="fixed flex justify-center items-center inset-0 z-50 hidden overflow-y-auto">
    <!-- Background overlay with animation -->
    <div id="organizerModalBackdrop"
        class="fixed inset-0 bg-gray-900/70 backdrop-blur-sm opacity-0 transition-opacity duration-300"></div>

    <!-- Modal panel with animation -->
    <div id="organizerModalPanel"
        class="relative bg-white rounded-2xl shadow-2xl transform transition-all duration-300 w-full max-w-lg max-h-[90vh] overflow-y-auto translate-y-4 opacity-0 scale-95 border border-gray-100">

        <!-- Modal header with icon -->
        <div class="sticky top-0 bg-white px-6 pt-5 pb-2 border-b border-gray-100 z-10">
            <div class="flex items-start gap-4">
                <div
                    class="p-3 rounded-xl bg-gradient-to-tr from-indigo-500 to-indigo-600 text-white shadow-lg ">
                    <i class="ri-community-line text-2xl"></i>
                </div>
                <div class="flex-1">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-800 tracking-tight">Create New Organization</h3>
                            <p class="text-indigo-600/80 text-lg mt-1">Build your organization profile</p>
                        </div>
                        <button id="closeOrganizerModal"
                            class="text-gray-400 hover:text-gray-600 focus:outline-none transition-all duration-300 hover:rotate-90 hover:scale-110">
                            <i class="ri-close-line text-2xl"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <form id="create-organization-form" action="{{ route('organization.store') }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            <div class="px-6 py-4 space-y-6">

                <!-- Name Field with Icon -->
                <div class="relative group">
                    <input type="text" id="organizationName" name="name"
                        class="w-full px-5 py-4 pl-14 text-lg rounded-xl border-2 border-gray-200 focus:border-indigo-400 focus:ring-0 bg-white text-gray-800 transition-all duration-300 shadow-sm group-hover:border-indigo-300 peer"
                        placeholder=" " required>
                    <label for="organizationName"
                        class="absolute left-14 top-4 px-2 text-gray-500 text-lg transition-all duration-300 transform -translate-y-9 scale-90 bg-white rounded peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-9 peer-focus:scale-90 peer-focus:text-indigo-600">
                        Organization Name
                    </label>
                    <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-indigo-500">
                        <i class="ri-community-line text-2xl"></i>
                    </div>
                </div>
            </div>

            <!-- Modal footer -->
            <div class="sticky bottom-0 bg-white px-6 py-4 border-t border-gray-100">
                <div class="flex justify-end space-x-3">
                    <button id="cancelOrganizerModal" type="button"
                        class="px-5 py-2.5 border-2 border-gray-200 rounded-xl bg-white text-sm font-medium text-gray-700 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all duration-300 hover:shadow-md hover:-translate-y-0.5 active:translate-y-0 flex items-center gap-2">
                        <i class="ri-close-line"></i> Cancel
                    </button>
                    <button type="submit"
                        class="px-5 py-2.5 border-2 border-transparent rounded-xl bg-gradient-to-r from-indigo-500 to-indigo-600 text-sm font-medium text-white hover:from-indigo-600 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all duration-300 hover:shadow-lg hover:-translate-y-0.5 active:translate-y-0 flex items-center gap-2 group">
                        <i class="ri-add-line transition-transform group-hover:rotate-90"></i> Create Organization
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    document.querySelector('form[id="create-organization-form"]').addEventListener('submit', function(e) {
        e.preventDefault();
        const form = this;
        const formData = new FormData(form);
        const submitBtn = form.querySelector('button[type="submit"]');

        submitBtn.disabled = true;
        submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Creating...';

        fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value,
                },
            }).then(async (res) => {
                const data = await res.json();

                if (res.ok && data.success) {
                    Swal.fire({
                        title: 'Success!',
                        text: data.message,
                        icon: 'success',
                        confirmButtonColor: '#6366F1'
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    Swal.fire({
                        title: 'Oops!',
                        html: (data.errors || ['Something went wrong']).join("<br>"),
                        icon: 'error',
                        confirmButtonColor: '#EF4444'
                    });
                }
            })
            .catch(() => {
                Swal.fire({
                    title: 'Oops!',
                    text: 'Something went wrong',
                    icon: 'error',
                    confirmButtonColor: '#EF4444'
                });
            })
            .finally(() => {
                submitBtn.disabled = false;
                submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                submitBtn.innerHTML = '<i class="ri-add-line"></i> Create Organization';
            });
    });
</script>
