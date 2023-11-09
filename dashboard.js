import { initializeApp } from "https://www.gstatic.com/firebasejs/10.5.0/firebase-app.js";
import { getDatabase, ref, get } from "https://www.gstatic.com/firebasejs/10.5.0/firebase-database.js";

// Firebase configuration
const firebaseConfig = {
  apiKey: "AIzaSyBiya-MbWDnCcsM-CL36LvY7oduMMxVRsQ",
  authDomain: "uya-travel.firebaseapp.com",
  databaseURL: "https://uya-travel-default-rtdb.firebaseio.com",
  projectId: "uya-travel",
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);
const db = getDatabase(app);
const dbRef = ref(db);

// Function to fetch data and update the dashboard
const updateDashboard = () => {
  // Fetch data from the database
  // Replace these paths with the actual paths to your data in the Firebase database
  const totalBookingsRef = ref(db, 'total_bookings');
  const activeBookingsRef = ref(db, 'active_bookings');
  const cancelledBookingsRef = ref(db, 'cancelled_bookings');
  
  // Use the `get` method to fetch the data
  Promise.all([
    get(totalBookingsRef),
    get(activeBookingsRef),
    get(cancelledBookingsRef)
  ]).then((responses) => {
    // Update the dashboard elements with the fetched data
    const totalBookings = responses[0].val();
    const activeBookings = responses[1].val();
    const cancelledBookings = responses[2].val();

    // Update the HTML elements with the fetched data
    document.getElementById('total_bookings').textContent = totalBookings;
    document.getElementById('active_bookings').textContent = activeBookings;
    document.getElementById('cancelled_bookings').textContent = cancelledBookings;
  }).catch((error) => {
    console.error("Error fetching data:", error);
  });
};

// Call the updateDashboard function to initially populate the dashboard
updateDashboard();
