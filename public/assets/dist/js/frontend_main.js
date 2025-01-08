


        document.querySelectorAll('input[name="size"]').forEach(sizeInput => {
            sizeInput.addEventListener('change', () => {
                document.getElementById('selectedSize').value = sizeInput.value;
            });
        });

        document.querySelectorAll('input[name="color"]').forEach(colorInput => {
            colorInput.addEventListener('change', () => {
                document.getElementById('selectedColor').value = colorInput.value;
            });
        });

        let thumbnails = document.querySelectorAll('.thumbnail');
        let currentImageIndex = 0;

        function changeImage(src, thumbnail) {
            document.getElementById('mainImage').src = src;
            document.querySelectorAll('.thumbnail').forEach(img => img.classList.remove('active'));
            thumbnail.classList.add('active');
        }

        function autoChangeImage() {
            currentImageIndex++;
            if (currentImageIndex >= thumbnails.length) {
                currentImageIndex = 0;
            }
            let selectedThumbnail = thumbnails[currentImageIndex];
            changeImage(selectedThumbnail.src, selectedThumbnail);
        }

        setInterval(autoChangeImage, 3000);

        const quantityInput = document.getElementById('quantity');
        const decreaseBtn = document.getElementById('decreaseBtn');
        const increaseBtn = document.getElementById('increaseBtn');

        decreaseBtn.addEventListener('click', () => {
            let currentValue = parseInt(quantityInput.value);
            if (currentValue > 1) {
                quantityInput.value = currentValue - 1;
                document.getElementById('selectedQuantity').value = currentValue - 1;
            }
        });

        increaseBtn.addEventListener('click', () => {
            let currentValue = parseInt(quantityInput.value);
            quantityInput.value = currentValue + 1;
            document.getElementById('selectedQuantity').value = currentValue + 1;
        });

        document.addEventListener("DOMContentLoaded", function() {
            const sizeRadioButtons = document.querySelectorAll('.size-options input[type="radio"]');
            const colorRadioButtons = document.querySelectorAll('.color-options input[type="radio"]');
            const addToCartButton = document.querySelector('.cart-btn');
            const sizeLabels = document.querySelectorAll('.size-options label');
            const colorLabels = document.querySelectorAll('.color-options label');
            const selectedSizeInput = document.getElementById('selectedSize');
            const selectedColorInput = document.getElementById('selectedColor');
            const quantityInput = document.getElementById('quantity');

            // Handle active state for size selection
            sizeRadioButtons.forEach(function(button) {
                button.addEventListener('change', function() {
                    sizeLabels.forEach(function(label) {
                        label.classList.remove('active');
                        label.style.borderColor = ''; // Reset border color
                    });
                    this.closest('label').classList.add('active');
                    selectedSizeInput.value = this.value; // Set selected size
                });
            });

            // Handle active state for color selection
            colorRadioButtons.forEach(function(button) {
                button.addEventListener('change', function() {
                    colorLabels.forEach(function(label) {
                        label.classList.remove('active');
                        label.style.borderColor = ''; // Reset border color
                    });
                    this.closest('label').classList.add('active');
                    selectedColorInput.value = this.value; // Set selected color
                });
            });

            // Validate form submission
            addToCartButton.addEventListener('click', function(event) {
                let valid = true;

                // Validate sizes if they exist
                if (sizeRadioButtons.length > 0 && !selectedSizeInput.value) {
                    valid = false;
                    sizeLabels.forEach(function(label) {
                        label.style.borderColor = 'red'; // Highlight in red
                    });
                }

                // Validate colors if they exist
                if (colorRadioButtons.length > 0 && !selectedColorInput.value) {
                    valid = false;
                    colorLabels.forEach(function(label) {
                        label.style.borderColor = 'red'; // Highlight in red
                    });
                }

                if (!valid) {
                    event.preventDefault(); // Prevent form submission
                } else {
                    document.getElementById('selectedQuantity').value = quantityInput
                        .value; // Set selected quantity
                }
            });
        });



        function changeImage(imageSrc, thumbnailElement) {
            document.getElementById('mainImage').src = imageSrc;
            var thumbnails = document.querySelectorAll('.thumbnail');
            thumbnails.forEach(function(thumbnail) {
                thumbnail.classList.remove('active');
            });
            thumbnailElement.classList.add('active');
        }

        function changeColorImage(colorImageSrc) {
            document.getElementById('mainImage').src = colorImageSrc;
        }

        function orderOnWhatsApp() {
            const productTitle = "{{ $product->title }}";
            const productImage = document.getElementById('mainImage').src;
            const selectedQuantity = document.getElementById('quantity').value;
            const selectedSize = document.getElementById('selectedSize').value || 'N/A';
            const selectedColor = document.getElementById('selectedColor').value || 'N/A';
            const productPrice = "{{ number_format($product->price, 2) }}";

            // WhatsApp Number (Replace with your number)
            const whatsappNumber = "{{ $storeSettings->whatsapp_number }}"; // Format: 92xxxxxxxxxx (Pakistan)

            // WhatsApp Message
            let message = `Product: ${productTitle}%0A`;
            message += `Price:  ${productPrice} PKR%0A`;
            message += `%0A`;
            message += `Hello, I want to order the following product:%0A`;

            // Redirect to WhatsApp
            const whatsappUrl = `https://wa.me/${whatsappNumber}?text=${message}`;
            window.open(whatsappUrl, '_blank');
        }
