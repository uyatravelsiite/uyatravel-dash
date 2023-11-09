// Initialize Firebase with your Firebase project configuration
const firebaseConfig = {
    apiKey: "AIzaSyBiya-MbWDnCcsM-CL36LvY7oduMMxVRsQ",
    authDomain: "uya-travel.firebaseapp.com",
    databaseURL: "https://uya-travel-default-rtdb.firebaseio.com",
    projectId: "uya-travel",
    storageBucket: "uya-travel.appspot.com",
    messagingSenderId: "283228218463",
    appId: "1:283228218463:web:1320b719aabcf813dfa7ea",
    measurementId: "G-ZQYT7T1X7E"
  };
  firebase.initializeApp(firebaseConfig);
  
  const db = firebase.firestore();
  const storage = firebase.storage(); // Initialize Firebase Storage
  
  // Reference to the 'products' collection in Firestore
  const productsRef = db.collection('products');
  
  // Handle the form submission
  const productForm = document.getElementById('product-form');
  productForm.addEventListener('submit', function (e) {
      e.preventDefault();
  
      const name = document.getElementById('name').value;
      const price = document.getElementById('price').value;
      const description = document.getElementById('description').value;
      const image = document.getElementById('image').files[0]; // Get selected image
  
      if (name && price && image) {
          // Upload the image to Firebase Storage
          const imageRef = storage.ref().child(image.name);
          imageRef.put(image)
              .then(snapshot => snapshot.ref.getDownloadURL()) // Get the image URL
              .then(url => {
                  // Add product data to Firestore including the image URL
                  productsRef.add({
                      name: name,
                      price: parseFloat(price),
                      description: description,
                      imageUrl: url, // Include image URL
                  })
                  .then(function() {
                      productForm.reset();
                  })
                  .catch(function(error) {
                      console.error("Error adding product: ", error);
                  });
              })
              .catch(function(error) {
                  console.error("Error uploading image: ", error);
              });
      }
  });
  
  // Listen for real-time updates from Firestore
  productsRef.onSnapshot(function(querySnapshot) {
      const productList = document.getElementById('product-list');
      productList.innerHTML = '';
  
      querySnapshot.forEach(function(doc) {
          const data = doc.data();
          productList.innerHTML += `<li>
              <strong>${data.name}: $${data.price}</strong><br>
              Description: ${data.description}<br>
              <img src="${data.imageUrl}" alt="${data.name} Image" width="100" height="100">
          </li>`;
      });
  });
  