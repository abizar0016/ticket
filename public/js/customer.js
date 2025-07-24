document.addEventListener("DOMContentLoaded", function () {
    // 1. Cart Storage Functions
    function saveCartToStorage() {
        const cartData = {
            data: cart,
            timestamp: new Date().getTime(),
        };
        localStorage.setItem("shoppingCart", JSON.stringify(cartData));
    }
    function loadCartFromStorage() {
        const cartData = JSON.parse(localStorage.getItem("shoppingCart"));
        if (cartData) {
            const now = new Date();
            const cartTime = new Date(cartData.timestamp);
            // Tambahkan 1 bulan ke waktu cart
            const oneMonthLater = new Date(cartTime);
            oneMonthLater.setMonth(cartTime.getMonth() + 1);
            const isExpired = now > oneMonthLater;
            return isExpired ? [] : cartData.data;
        }
        return [];
    }

    // 2. Initialize cart from storage
    let cart = loadCartFromStorage();

    // 3. Cart sidebar elements
    const cartSidebar = document.getElementById("cart-sidebar");
    const cartToggle = document.getElementById("cart-toggle");
    const closeCart = document.getElementById("close-cart");

    // 4. Toggle cart sidebar with animation
    if (cartToggle) {
        cartToggle.addEventListener("click", function () {
            cartSidebar.classList.toggle("translate-x-full");
            this.classList.toggle("rotate-12");
        });
    }

    if (closeCart) {
        closeCart.addEventListener("click", function () {
            cartSidebar.classList.add("translate-x-full");
            cartToggle.classList.remove("rotate-12");
        });
    }

    // 5. Toggle tickets/products visibility with smooth animation
    document.querySelectorAll(".view-tickets-btn").forEach((button) => {
        button.addEventListener("click", function () {
            const eventId = this.getAttribute("data-event");
            const section = document.querySelector(
                `#event-${eventId} .tickets-products-section`
            );
            if (!section) {
                console.log(
                    `Element #event-${eventId} .tickets-products-section not found`
                );
                return;
            }
            const icon = this.querySelector("i");

            // Toggle icon
            if (section.classList.contains("hidden")) {
                icon.classList.remove("fa-ticket-alt");
                icon.classList.add("fa-times");
            } else {
                icon.classList.remove("fa-times");
                icon.classList.add("fa-ticket-alt");
            }

            // Hide all other sections first
            document
                .querySelectorAll(".tickets-products-section")
                .forEach((sec) => {
                    if (sec !== section) {
                        sec.classList.add("hidden");
                        const btn = document.querySelector(
                            `.view-tickets-btn[data-event="${
                                sec.closest('[id^="event-"]').id.split("-")[1]
                            }"] i`
                        );
                        btn.classList.remove("fa-times");
                        btn.classList.add("fa-ticket-alt");
                    }
                });

            // Toggle current section with animation
            if (section.classList.contains("hidden")) {
                section.classList.remove("hidden");
                section.style.maxHeight = "0";
                section.style.overflow = "hidden";
                const finalHeight = section.scrollHeight + "px";

                setTimeout(() => {
                    section.style.transition = "max-height 0.5s ease-out";
                    section.style.maxHeight = finalHeight;

                    setTimeout(() => {
                        section.style.maxHeight = "none";
                        section.style.transition = "";
                    }, 500);
                }, 10);
            } else {
                section.style.maxHeight = section.scrollHeight + "px";
                section.style.transition = "max-height 0.3s ease-in";

                setTimeout(() => {
                    section.style.maxHeight = "0";

                    setTimeout(() => {
                        section.classList.add("hidden");
                        section.style.maxHeight = "";
                        section.style.transition = "";
                    }, 300);
                }, 10);
            }

            // Scroll to section smoothly
            setTimeout(() => {
                section.scrollIntoView({
                    behavior: "smooth",
                    block: "nearest",
                });
            }, 50);
        });
    });

    // 6. Quantity controls with animation
    document.querySelectorAll(".quantity-minus").forEach((button) => {
        button.addEventListener("click", function () {
            const input = this.nextElementSibling;
            if (parseInt(input.value) > parseInt(input.min)) {
                input.value = parseInt(input.value) - 1;
                this.classList.add("scale-90");
                setTimeout(() => this.classList.remove("scale-90"), 200);
            } else {
                this.classList.add("shake");
                setTimeout(() => this.classList.remove("shake"), 500);
            }
        });
    });

    document.querySelectorAll(".quantity-plus").forEach((button) => {
        button.addEventListener("click", function () {
            const input = this.previousElementSibling;
            if (parseInt(input.value) < parseInt(input.max)) {
                input.value = parseInt(input.value) + 1;
                this.classList.add("scale-90");
                setTimeout(() => this.classList.remove("scale-90"), 200);
            } else {
                this.classList.add("shake");
                setTimeout(() => this.classList.remove("shake"), 500);
            }
        });
    });

    // 7. Session selection
    document
        .querySelectorAll(".size-option, .session-option")
        .forEach((option) => {
            option.addEventListener("click", function (e) {
                e.preventDefault();
                const parent = this.parentElement;
                parent
                    .querySelectorAll(".size-option, .session-option")
                    .forEach((btn) => {
                        btn.classList.remove(
                            "active",
                            "bg-indigo-100",
                            "border-indigo-500"
                        );
                    });
                this.classList.add(
                    "active",
                    "bg-indigo-100",
                    "border-indigo-500"
                );
            });
        });

    // 8. Add to cart functionality
    document.querySelectorAll(".add-to-cart").forEach((button) => {
        button.addEventListener("click", function () {
            consproductContainer = this.closest('#product-card');
            const eventId = this.getAttribute("data-event");
            const productId = this.getAttribute("data-product");
            const productType = this.getAttribute("data-type");
            const productName = productContainer.querySelector("h4").textContent;
            const productPrice = parseFloat(
                productContainer
                    .querySelector(".text-indigo-600")
                    .textContent.replace("Rp", "")
                    .replace(/\./g, "")
                    .replace(",", ".")
            );

            const quantity = parseInt(
                productContainer.querySelector('input[type="number"]').value
            );

            // Check if product already exists in cart
            const existingItemIndex = cart.findIndex(
                (item) =>
                    item.productId === productId && item.eventId === eventId
            );

            if (existingItemIndex >= 0) {
                // Update quantity if exists
                cart[existingItemIndex].quantity += quantity;
            } else {
                // Add new item to cart
                cart.push({
                    eventId: eventId,
                    productId: productId,
                    name: productName,
                    price: productPrice,
                    quantity: quantity,
                    type: productType,
                });
            }

            // Save to storage and update UI
            saveCartToStorage();
            updateCartUI();

            // Show cart sidebar if closed
            if (cartSidebar.classList.contains("translate-x-full")) {
                cartSidebar.classList.remove("translate-x-full");
            }

            // Create flying cart animation
            const buttonRect = this.getBoundingClientRect();
            const cartRect = cartToggle.getBoundingClientRect();

            const flyingItem = document.createElement("div");
            flyingItem.className = "fixed z-50 text-indigo-600";
            flyingItem.innerHTML = '<i class="fas fa-shopping-cart"></i>';
            flyingItem.style.left = `${
                buttonRect.left + buttonRect.width / 2
            }px`;
            flyingItem.style.top = `${buttonRect.top}px`;
            flyingItem.style.transform = "translate(-50%, -50%) scale(1)";
            document.body.appendChild(flyingItem);

            // Animate to cart
            const animation = flyingItem.animate(
                [
                    {
                        left: `${buttonRect.left + buttonRect.width / 2}px`,
                        top: `${buttonRect.top}px`,
                        opacity: 1,
                        transform: "translate(-50%, -50%) scale(1)",
                    },
                    {
                        left: `${cartRect.left + cartRect.width / 2}px`,
                        top: `${cartRect.top + cartRect.height / 2}px`,
                        opacity: 0,
                        transform: "translate(-50%, -50%) scale(0.5)",
                    },
                ],
                {
                    duration: 800,
                    easing: "cubic-bezier(0.4, 0, 0.2, 1)",
                }
            );

            animation.onfinish = () => {
                flyingItem.remove();
                // Bounce cart icon
                cartToggle.classList.add("animate-bounce");
                setTimeout(
                    () => cartToggle.classList.remove("animate-bounce"),
                    1000
                );
            };

            // Show success message
            Swal.fire({
                title: "Success!",
                text: `${quantity} × ${productName} added to cart.`,
                icon: "success",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                position: "bottom-start",
                toast: true,
            });
        });
    });

    // 9. Update cart UI with animations
    function updateCartUI() {
        const cartItemsContainer = document.getElementById("cart-items");
        const cartSubtotalElement = document.getElementById("cart-subtotal");
        const cartTotalElement = document.getElementById("cart-total");
        const cartCountElement = document.getElementById("cart-count");
        const emptyCartMsg = document.getElementById("empty-cart-message");
        const cartSummary = document.getElementById("cart-summary");
        const checkoutBtn = document.getElementById("checkout-btn");

        if (
            !cartItemsContainer ||
            !cartSubtotalElement ||
            !cartTotalElement ||
            !cartCountElement ||
            !emptyCartMsg ||
            !cartSummary
        ) {
            return;
        }

        // Fade out existing items
        const existingItems = cartItemsContainer.querySelectorAll(
            ":not(#empty-cart-message)"
        );
        existingItems.forEach((item) => {
            item.style.transition = "opacity 0.3s ease";
            item.style.opacity = "0";

            setTimeout(() => {
                item.remove();
            }, 300);
        });

        let subtotal = 0;
        let itemCount = 0;

        if (cart.length === 0) {
            emptyCartMsg.classList.remove("hidden");
            cartSummary.classList.add("hidden");
            checkoutBtn.classList.add("hidden");
            cartCountElement.classList.add("hidden");
            return;
        }

        emptyCartMsg.classList.add("hidden");
        cartSummary.classList.remove("hidden");
        checkoutBtn.classList.remove("hidden");

        // Add new items with animation
        cart.forEach((item, index) => {
            const itemTotal = item.price * item.quantity;
            subtotal += itemTotal;
            itemCount += item.quantity;

            const itemElement = document.createElement("div");
            itemElement.className =
                "flex justify-between items-start border-b border-gray-200 pb-4 opacity-0 transform translate-x-4";
            itemElement.style.transition = "all 0.3s ease";
            itemElement.style.transitionDelay = `${index * 0.05}s`;

            itemElement.innerHTML = `
                <div class="flex-grow">
                    <div class="flex items-center">
                        <h4 class="font-medium">${item.name}</h4>
                    </div>
                </div>
                <div class="text-right ml-4">
                    <div class="font-medium">Rp ${itemTotal.toLocaleString(
                        "id-ID"
                    )}</div>
                    <div class="text-xs text-gray-500">${
                        item.quantity
                    } × Rp ${item.price.toLocaleString("id-ID")}</div>
                </div>
                <button class="ml-2 mt-2 text-gray-400 hover:text-red-500 remove-item transition-colors duration-200" data-index="${index}">
                    <i class="ri-delete-bin-line text-xl"></i>
                </button>
            `;

            cartItemsContainer.appendChild(itemElement);

            // Animate item in
            setTimeout(() => {
                itemElement.style.opacity = "1";
                itemElement.style.transform = "translateX(0)";
            }, 10);
        });

        // Update totals with counting animation
        animateValue(cartSubtotalElement, 0, subtotal, 500, "Rp ");
        animateValue(cartTotalElement, 0, subtotal, 500, "Rp ");

        // Update cart count with animation
        if (parseInt(cartCountElement.textContent) !== itemCount) {
            cartCountElement.classList.add("scale-125");
            setTimeout(
                () => cartCountElement.classList.remove("scale-125"),
                200
            );
        }
        cartCountElement.textContent = itemCount;
        cartCountElement.classList.remove("hidden");

        // Add event listeners to remove buttons
        document.querySelectorAll(".remove-item").forEach((button) => {
            button.addEventListener("click", function () {
                const index = parseInt(this.getAttribute("data-index"));
                cart.splice(index, 1);
                saveCartToStorage();
                updateCartUI();

                // Show removed message
                Swal.fire({
                    title: "Removed",
                    text: "Product removed from cart.",
                    icon: "info",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    position: "bottom-start",
                    toast: true,
                });
            });
        });
    }

    // 10. Animate number counting
    function animateValue(element, start, end, duration, prefix = "") {
        let startTimestamp = null;
        const step = (timestamp) => {
            if (!startTimestamp) startTimestamp = timestamp;
            const progress = Math.min(
                (timestamp - startTimestamp) / duration,
                1
            );
            const value = Math.floor(progress * (end - start) + start);
            element.textContent = prefix + value.toLocaleString("id-ID");
            if (progress < 1) {
                window.requestAnimationFrame(step);
            }
        };
        window.requestAnimationFrame(step);
    }

    // 11. Checkout functionality
    const checkoutBtn = document.getElementById("checkout-btn");
    if (checkoutBtn) {
        checkoutBtn.addEventListener("click", function () {
            this.classList.add("opacity-75", "cursor-not-allowed");
            this.innerHTML =
                '<i class="fas fa-spinner fa-spin mr-2"></i> Processing...';

            const cartForm = document.getElementById("checkout-form");
            const cartInput = document.getElementById("cart-data-input");

            if (cartForm && cartInput) {
                cartInput.value = JSON.stringify(cart);
                cartForm.submit();
            }
        });
    }

    // 12. Initial UI update
    updateCartUI();

    // 13. Copy attendee names and emails
    const copyBtn = document.getElementById("copy-attendee-btn");
    if (copyBtn) {
        copyBtn.addEventListener("click", () => {
            const names = document.querySelectorAll(".attendee-name");
            const emails = document.querySelectorAll(".attendee-email");
            if (names.length < 2 || emails.length < 2) return;
            const baseName = names[0].value.trim();
            const baseEmail = emails[0].value.trim();
            if (!baseName || !baseEmail) {
                alert("Isi nama dan email pertama terlebih dahulu.");
                return;
            }
            for (let i = 1; i < names.length; i++) {
                names[i].value = baseName;
                emails[i].value = baseEmail;
            }
        });
    }
});
