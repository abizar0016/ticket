<div id="cart-sidebar"
    class="fixed right-0 top-0 h-full w-96 bg-white shadow-2xl transform translate-x-full transition-transform duration-500 ease-in-out z-50 overflow-y-auto">
    <div class="p-6 h-full flex flex-col">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800 flex items-center">
                <i class="fas fa-shopping-bag mr-3 text-indigo-600"></i>
                Your Cart
            </h2>
            <button id="close-cart"
                class="text-gray-500 hover:text-gray-700 transition-colors duration-200 transform hover:scale-110">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <div id="cart-items" class="flex-grow mb-6 space-y-4">
            <div class="text-center text-gray-500 py-12 flex flex-col items-center justify-center h-full"
                id="empty-cart-message">
                <div class="relative mb-6">
                    <i class="fas fa-shopping-cart text-5xl opacity-20"></i>
                </div>
                <p class="text-lg font-medium mb-2">Your cart is empty</p>
                <p class="text-sm max-w-xs">Browse our events and add tickets or merchandise to get started
                </p>
            </div>
        </div>

        <div class="border-t border-gray-200 pt-4 mb-6 hidden" id="cart-summary">
            <div class="flex justify-between items-center mb-4">
                <span class="font-medium text-gray-600">Subtotal:</span>
                <span id="cart-subtotal" class="font-medium">Rp 0</span>
            </div>
            <div class="flex justify-between items-center text-lg font-bold">
                <span>Total:</span>
                <span id="cart-total" class="text-indigo-600">Rp 0</span>
            </div>
        </div>

        <button id="checkout-btn"
            class="w-full bg-gradient-to-r from-indigo-500 to-indigo-600 text-white py-3 px-4 rounded-lg hover:from-indigo-700 hover:to-indigo-800 transition-all duration-300 font-medium hidden transform hover:scale-105 shadow-lg hover:shadow-xl active:scale-95">
            Proceed to Checkout
            <i class="fas fa-arrow-right ml-2"></i>
        </button>
    </div>
</div>
