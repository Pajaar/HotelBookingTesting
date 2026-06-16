// Initialize on page load
$(document).ready(function() {
    // Setup datepickers
    $('#checkinDate').datepicker({
        dateFormat: 'D, dd M yy',
        minDate: 0,
        onSelect: function() {
            var checkin = $(this).datepicker('getDate');
            var nextDay = new Date(checkin);
            nextDay.setDate(nextDay.getDate() + 1);
            $('#checkoutDate').datepicker('option', 'minDate', nextDay);
            $('#checkinInput').val($.datepicker.formatDate('yy-mm-dd', checkin));
            calculatePrice();
        }
    });

    $('#checkoutDate').datepicker({
        dateFormat: 'D, dd M yy',
        minDate: 1,
        onSelect: function() {
            var checkout = $(this).datepicker('getDate');
            $('#checkoutInput').val($.datepicker.formatDate('yy-mm-dd', checkout));
            calculatePrice();
        }
    });

    // Set default dates (today and tomorrow)
    var today = new Date();
    var tomorrow = new Date(today);
    tomorrow.setDate(tomorrow.getDate() + 1);
    
    $('#checkinDate').datepicker('setDate', today);
    $('#checkoutDate').datepicker('setDate', tomorrow);
    $('#checkinInput').val($.datepicker.formatDate('yy-mm-dd', today));
    $('#checkoutInput').val($.datepicker.formatDate('yy-mm-dd', tomorrow));
    
    // Initial calculation
    calculatePrice();

    // Room selection handler
    $('.room-radio').on('change', function() {
        var roomType = $(this).data('type');
        $('#selectedRoomType').text('(1x) ' + roomType);
        calculatePrice();
    });

    // Auto-show payment modal if redirect from booking
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('show_payment') === '1') {
        // Pastikan booking_id dari URL masuk ke hidden input form
        var bookingId = urlParams.get('booking_id');
        if (bookingId) {
            $('#modalBookingIdInput').val(bookingId);
        }
        $('#paymentModal').fadeIn(300);
    }
});

// Guest Counter Click Handlers
$('#adultPlus').click(function() {
    changeGuest('adult', 1);
});

$('#adultMinus').click(function() {
    changeGuest('adult', -1);
});

$('#childPlus').click(function() {
    changeGuest('child', 1);
});

$('#childMinus').click(function() {
    changeGuest('child', -1);
});

// Calculate nights, price, and update display
function calculatePrice() {
    var checkin = $('#checkinDate').datepicker('getDate');
    var checkout = $('#checkoutDate').datepicker('getDate');
    
    if (checkin && checkout) {
        // Calculate nights
        var nights = Math.ceil((checkout - checkin) / (1000 * 60 * 60 * 24));
        
        if (nights > 0) {
            // Update nights display
            $('#durationDisplay').text(nights + ' Night' + (nights > 1 ? 's' : ''));
            $('#nightsInput').val(nights);
            
            // Get selected room price
            var roomPrice = parseFloat($('.room-radio:checked').data('price')) || 0;
            var tax = 150000;
            var total = (roomPrice * nights) + tax;
            
            // Update price display
            $('#pricePerNight').text('Rp ' + roomPrice.toLocaleString('id-ID'));
            $('#totalPrice').text('Rp ' + total.toLocaleString('id-ID'));
        }
    }
}

// Guest counter
function changeGuest(type, delta) {
    var countEl = $('#' + type + 'Count');
    var inputEl = $('#' + type + 'Input');
    var count = parseInt(countEl.text()) + delta;
    
    // Validation
    if (type === 'adult' && count < 1) return;
    if (count < 0) return;
    
    // Update counter display
    countEl.text(count);
    inputEl.val(count);
    
    // Update guest display di room info
    var adultCount = parseInt($('#adultCount').text());
    var childCount = parseInt($('#childCount').text());
    
    $('#totalGuests').text(adultCount + ' Guest' + (adultCount > 1 ? 's' : ''));
    $('#totalChildren').text(childCount + ' Child'+ (childCount > 1 ? 'ren' : ''));
}

// Close Payment Modal
function closePaymentModal() {
    $('#paymentModal').fadeOut(300);
    var url = new URL(window.location);
    url.searchParams.delete('show_payment');
    window.history.replaceState({}, document.title, url);
}

// Close modal when clicking outside
$(document).on('click', function(e) {
    if ($(e.target).is('#paymentModal')) {
        closePaymentModal();
    }
});
