<div id="modalAddCategory" class="fixed flex hidden justify-center items-center inset-0 z-50 overflow-y-auto">

    <div id="modalAddCategoryBackdrop"
        class="fixed inset-0 bg-gray-900/70 backdrop-blur-sm transition-opacity duration-300"></div>

    <div id="modalAddCategoryPanel"
        class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-2xl transform transition-all duration-300 w-full max-w-lg max-h-[90vh] overflow-y-auto translate-y-4 scale-95 border border-gray-100 dark:border-gray-600">

        <div class="sticky top-0 px-6 pt-5 pb-2 border-b border-gray-100 dark:border-gray-600 z-10">
            <div class="flex items-start justify-between">
                <div class="flex items-start gap-4">
                    <div class="p-3 rounded-xl bg-gradient-to-tr from-indigo-500 to-indigo-600 text-white shadow-lg">
                    <i class="ri-community-line text-2xl"></i>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-gray-800  dark:text-white tracking-tight">Create Category</h3>
                        <p class="text-indigo-600 dark:text-indigo-400 text-lg mt-1">Add a new category for better organizations.</p>
                    </div>
                </div>
                <button id="closeAddCategoryModal" class="text-gray-400 hover:text-gray-500 transition-colors duration-200">
                    <i class="ri-close-line text-2xl"></i>
                </button>
            </div>
        </div>

        <form id="create-category-form" class="ajax-form" data-success="Category created successfully." action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="px-6 py-4 space-y-6">
                <div class="relative group">
                    <input type="text" id="categoryName" name="name"
                        class="w-full px-5 py-4 pl-14 pr-4 text-lg rounded-xl border-2 border-gray-200 dark:border-gray-600 
                                focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 
                                bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100 
                                transition-all duration-300 shadow-sm group-hover:border-indigo-300 peer outline-none"
                        placeholder=" " required>
                    <label for="categoryName"
                        class="absolute left-14 top-4 px-1 text-gray-500 dark:text-gray-400 text-base 
                                transition-all duration-300 transform -translate-y-9 scale-90 
                                bg-white dark:bg-gray-700 rounded 
                                peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 
                                peer-focus:-translate-y-9 peer-focus:scale-90 
                                peer-focus:text-indigo-600 dark:peer-focus:text-indigo-400 font-medium">
                        Category Name
                    </label>
                    <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-indigo-500 dark:text-indigo-400">
                        <i class="ri-community-line text-2xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 px-5 py-4 sm:flex sm:justify-end rounded-b-xl mt-6">
                <div class="flex justify-end space-x-3">
                    <button type="submit"
                        class="w-full inline-flex justify-center items-center rounded-xl border border-transparent shadow-sm px-6 py-3 
                            bg-gradient-to-r from-indigo-500 to-indigo-600 text-white text-base font-semibold 
                            hover:from-indigo-600 hover:to-indigo-700 focus:outline-none focus:ring-2 
                            focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto 
                            transition-all duration-300 transform hover:-translate-y-0.5 hover:shadow-md cursor-pointer">
                        <i class="ri-add-line transition-transform group-hover:rotate-90"></i> Create Category
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
