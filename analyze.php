<!-- <html>
<iframe src="http://124.29.197.223:3000" 
    style="position:absolute; top:0; left:0; width:100%; height:100%; border:none;">
</iframe>
</html> -->

<html>
<head>
    <script>
        // Get the current URL
        let url = new URL(window.location.href);

        // Use URLSearchParams to extract query parameters
        let params = new URLSearchParams(url.search);

        let domain = params.get('domain');

        // domain = decodeURIComponent(domain);

        // domain = encodeURIComponent(ddomain)

        window.onload = function() {
            // Check if user data is present in localStorage
            const userData = localStorage.getItem('user');
            if (userData) {
                // Parse the user data from JSON format
                const user = JSON.parse(userData);
                const isPaid = user.isPaid;  // isPaid value
                const eventCount = user.eventCount;  // Event count value

                if (isPaid == 0) {
                    // If user is not paid, check event count
                    if (eventCount >= 3) {
                        alert('You have reached the free limit. Please purchase a paid plan for more usage.');
                    } else {
                        // Allow access if event count is less than 3
                        console.log('Access granted, event count: ' + (3 - eventCount));
                        // Continue with loading the iframe
                        loadIframe();
                    }
                } else {
                    // If the user is paid, grant unlimited access
                    console.log('Paid user, unlimited access');
                    // Continue with loading the iframe
                    loadIframe();
                }
            } else {
                // If no user data in localStorage, redirect to login page
                window.location.href = 'http://localhost:80/WebSA/login.html';
            }
        }

        // Function to load iframe
        function loadIframe() {
            const iframe = document.createElement('iframe');
            iframe.src = `http://localhost:3000/check/${domain}`;
            iframe.style.position = "absolute";
            iframe.style.top = "0";
            iframe.style.left = "0";
            iframe.style.width = "100%";
            iframe.style.height = "100%";
            iframe.style.border = "none";
            document.body.appendChild(iframe);  // Add iframe to the body
        }
    </script>
</head>
<body>
    <!-- The iframe will be dynamically inserted based on conditions. -->
</body>
</html>

