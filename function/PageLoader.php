
    <style>
        /* Spinner styles */
        .lds-spinner,
        .lds-spinner div,
        .lds-spinner div:after {
          box-sizing: border-box;
        }
        .lds-spinner {
          color: #007bff; /* Blue spinner color */
          display: inline-block;
          position: relative;
          width: 80px;
          height: 80px;
        }
        .lds-spinner div {
          transform-origin: 40px 40px;
          animation: lds-spinner 1.2s linear infinite;
        }
        .lds-spinner div:after {
          content: " ";
          display: block;
          position: absolute;
          top: 3.2px;
          left: 36.8px;
          width: 6.4px;
          height: 17.6px;
          border-radius: 20%;
          background: currentColor;
        }
        .lds-spinner div:nth-child(1) {
          transform: rotate(0deg);
          animation-delay: -1.1s;
        }
        .lds-spinner div:nth-child(2) {
          transform: rotate(30deg);
          animation-delay: -1s;
        }
        .lds-spinner div:nth-child(3) {
          transform: rotate(60deg);
          animation-delay: -0.9s;
        }
        .lds-spinner div:nth-child(4) {
          transform: rotate(90deg);
          animation-delay: -0.8s;
        }
        .lds-spinner div:nth-child(5) {
          transform: rotate(120deg);
          animation-delay: -0.7s;
        }
        .lds-spinner div:nth-child(6) {
          transform: rotate(150deg);
          animation-delay: -0.6s;
        }
        .lds-spinner div:nth-child(7) {
          transform: rotate(180deg);
          animation-delay: -0.5s;
        }
        .lds-spinner div:nth-child(8) {
          transform: rotate(210deg);
          animation-delay: -0.4s;
        }
        .lds-spinner div:nth-child(9) {
          transform: rotate(240deg);
          animation-delay: -0.3s;
        }
        .lds-spinner div:nth-child(10) {
          transform: rotate(270deg);
          animation-delay: -0.2s;
        }
        .lds-spinner div:nth-child(11) {
          transform: rotate(300deg);
          animation-delay: -0.1s;
        }
        .lds-spinner div:nth-child(12) {
          transform: rotate(330deg);
          animation-delay: 0s;
        }
        @keyframes lds-spinner {
          0% {
            opacity: 1;
          }
          100% {
            opacity: 0;
          }
        }

        /* Full-page overlay */
        .spinner-overlay {
          position: fixed;
          top: 0;
          left: 0;
          width: 100%;
          height: 100%;
          background-color: rgba(255, 255, 255, 0.9);
          display: flex;
          justify-content: center;
          align-items: center;
          z-index: 1050; /* Ensure it covers everything */
          transition: opacity 0.5s ease, visibility 0.5s ease;
          opacity: 1;
          visibility: visible;
        }

        /* Fade-out effect */
        .spinner-overlay.hidden {
          opacity: 0;
          visibility: hidden;
        }

        /* Mobile responsive styles */
        @media (max-width: 768px) {
          .lds-spinner {
            width: 50px;
            height: 50px;
          }
          .lds-spinner div:after {
            top: 2px;
            left: 22px;
            width: 4px;
            height: 12px;
          }
        }

        @media (max-width: 480px) {
          .lds-spinner {
            width: 40px;
            height: 40px;
          }
          .lds-spinner div:after {
            top: 1.6px;
            left: 18px;
            width: 3.2px;
            height: 10px;
          }
        }
    </style>
</head>
<body>
    <!-- Spinner Overlay -->
    <div class="spinner-overlay" id="spinnerOverlay">
        <div class="lds-spinner">
            <div></div><div></div><div></div><div></div><div></div>
            <div></div><div></div><div></div><div></div><div></div>
            <div></div><div></div>
        </div>
    </div>



    <script>
            window.onload = () => {
            const spinner = document.getElementById('spinnerOverlay');
            
            // Immediately or quickly hide the spinner after the page is fully loaded
            setTimeout(() => {
                spinner.classList.add('hidden');
            }, 500); // Set to a lower value for faster hide, e.g., 500ms
        };

    </script>
</body>
</html>
