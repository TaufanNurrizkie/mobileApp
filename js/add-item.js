document.getElementById('add-item-form').addEventListener('submit', function(event) {
    event.preventDefault();

    // Get form data
    const itemImage = document.getElementById('item-image').files[0];
    const itemName = document.getElementById('item-name').value;
    const itemDetails = document.getElementById('item-details').value;
    const itemPrice = document.getElementById('item-price').value;

    // Check if all fields are filled
    if (!itemImage || !itemName || !itemDetails || !itemPrice) {
        alert('Please fill all fields.');
        return;
    }

    // Create a new item object
    const newItem = {
        image: URL.createObjectURL(itemImage),
        name: itemName,
        details: itemDetails,
        price: itemPrice
    };

    // Save the new item to localStorage (or send to server)
    let items = JSON.parse(localStorage.getItem('items')) || [];
    items.push(newItem);
    localStorage.setItem('items', JSON.stringify(items));

    // Clear the form
    document.getElementById('add-item-form').reset();

    alert('Item added successfully!');
});
