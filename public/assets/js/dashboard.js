/**
 * Dashboard JavaScript for SD Normal Islam 2 Samarinda
 * Enhances mobile responsiveness and user experience
 */

document.addEventListener('DOMContentLoaded', function() {
  // Check if sidebar toggle exists and create one if it doesn't
  function ensureMobileSidebarToggle() {
    const pageWrapper = document.getElementById('main-wrapper');
    
    // Check if mobile toggle button exists
    if (!document.querySelector('.mobile-sidebar-toggle') && window.innerWidth < 1200) {
      // Create sidebar overlay if it doesn't exist
      if (!document.querySelector('.sidebar-overlay')) {
        const sidebarOverlay = document.createElement('div');
        sidebarOverlay.className = 'sidebar-overlay';
        document.body.appendChild(sidebarOverlay);
        
        sidebarOverlay.addEventListener('click', function() {
          pageWrapper.classList.remove('sidebar-open');
        });
      }
      
      // Create mobile toggle button
      const toggleButton = document.createElement('button');
      toggleButton.className = 'mobile-sidebar-toggle d-xl-none';
      toggleButton.innerHTML = '☰';
      toggleButton.setAttribute('aria-label', 'Toggle Sidebar');
      document.body.appendChild(toggleButton);
      
      toggleButton.addEventListener('click', function() {
        pageWrapper.classList.add('sidebar-open');
      });
    }
  }
  
  // Mobile optimizations
  function handleMobileOptimizations() {
    // Add mobile-friendly classes
    if (window.innerWidth < 768) {
      document.body.classList.add('mobile-view');
    } else {
      document.body.classList.remove('mobile-view');
    }
    
    // Ensure mobile sidebar toggle exists
    ensureMobileSidebarToggle();
    
    // Fix for iOS viewport height issues
    const vh = window.innerHeight * 0.01;
    document.documentElement.style.setProperty('--vh', `${vh}px`);
    
    // Handle tables on small screens
    const tables = document.querySelectorAll('table');
    tables.forEach(table => {
      if (!table.parentElement.classList.contains('table-responsive')) {
        const wrapper = document.createElement('div');
        wrapper.classList.add('table-responsive');
        table.parentNode.insertBefore(wrapper, table);
        wrapper.appendChild(table);
      }
    });
    
    // Make buttons full width on mobile
    if (window.innerWidth < 768) {
      const buttonGroups = document.querySelectorAll('.text-end, .text-right, .d-flex.justify-content-end');
      buttonGroups.forEach(group => {
        if (!group.classList.contains('mobile-processed')) {
          const buttons = group.querySelectorAll('.btn');
          buttons.forEach(button => {
            button.classList.add('btn-block', 'mb-2');
            button.style.width = '100%';
            button.style.marginLeft = '0';
            button.style.marginRight = '0';
          });
          group.classList.add('mobile-processed');
        }
      });
    }
  }
  
  // Handle form inputs on mobile
  function enhanceFormInputs() {
    const inputs = document.querySelectorAll('input, select, textarea');
    inputs.forEach(input => {
      // Increase tap target size on mobile
      if (window.innerWidth < 768) {
        input.style.minHeight = '42px';
        input.style.fontSize = '16px'; // Prevents iOS zoom on focus
      }
      
      // Add visual feedback on focus
      input.addEventListener('focus', function() {
        this.parentElement.classList.add('input-focused');
      });
      
      input.addEventListener('blur', function() {
        this.parentElement.classList.remove('input-focused');
      });
    });
  }
  
  // Form functionality
  function setupFormFunctionality() {
    // Check if we're on the formulir page
    const formElement = document.getElementById('formulirPendaftaran');
    if (!formElement) return;
    
    // Auto-save form data as user types
    const formInputs = formElement.querySelectorAll('input, select, textarea');
    formInputs.forEach(input => {
      input.addEventListener('change', function() {
        saveFormData(formElement);
      });
      
      if (input.type !== 'file') {
        input.addEventListener('input', function() {
          saveFormData(formElement);
        });
      }
    });
    
    // Helper function to save form data
    function saveFormData(form) {
      const formData = new FormData(form);
      const formObject = {};
      
      formData.forEach((value, key) => {
        formObject[key] = value;
      });
      
      localStorage.setItem('formulirData', JSON.stringify(formObject));
    }
    
    // Add export functionality for forms that need it
    setupExportFunctionality();
  }
  
  // Setup export functionality
  function setupExportFunctionality() {
    // Check if we're on a page that needs export functionality
    const exportPdfBtn = document.getElementById('exportPdfBtn');
    if (!exportPdfBtn) return;
    
    // Ensure jsPDF is available
    if (typeof window.jspdf === 'undefined' && typeof window.jsPDF === 'undefined') {
      const script = document.createElement('script');
      script.src = 'https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js';
      document.head.appendChild(script);
      
      const canvas = document.createElement('script');
      canvas.src = 'https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js';
      document.head.appendChild(canvas);
    }
  }
  
  // Handle orientation change
  function handleOrientationChange() {
    setTimeout(function() {
      handleMobileOptimizations();
      enhanceFormInputs();
      ensureMobileSidebarToggle();
    }, 200);
  }
  
  // Initialize
  handleMobileOptimizations();
  enhanceFormInputs();
  ensureMobileSidebarToggle();
  setupFormFunctionality();
  
  // Event listeners
  window.addEventListener('resize', handleMobileOptimizations);
  window.addEventListener('orientationchange', handleOrientationChange);
  
  // Fix for Safari and iOS
  if (/iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream) {
    document.documentElement.classList.add('ios-device');
  }
  
  // Improve touch interactions
  if ('ontouchstart' in window) {
    document.body.classList.add('touch-device');
    
    // Make buttons more touch-friendly
    const buttons = document.querySelectorAll('.btn');
    buttons.forEach(button => {
      button.style.minHeight = '44px';
    });
  }
  
  // Add active class to current menu item
  const currentPath = window.location.pathname;
  document.querySelectorAll('.sidebar-link').forEach(link => {
    if (link.getAttribute('href') === currentPath) {
      link.classList.add('active');
      link.closest('.sidebar-item')?.classList.add('selected');
    }
  });
});

$(function () {


  // -----------------------------------------------------------------------
  // sales overview
  // -----------------------------------------------------------------------

  var options_sales_overview = {
    series: [
      {
        name: "Ample Admin",
        data: [355, 390, 300, 350, 390, 180],
      },
      {
        name: "Pixel Admin",
        data: [280, 250, 325, 215, 250, 310],
      },
    ],
    chart: {
      type: "bar",
      height: 275,
      toolbar: {
        show: false,
      },
      foreColor: "#adb0bb",
      fontFamily: "inherit",
      sparkline: {
        enabled: false,
      },
    },
    grid: {
      show: false,
      borderColor: "transparent",
      padding: {
        left: 0,
        right: 0,
        bottom: 0,
      },
    },
    plotOptions: {
      bar: {
        horizontal: false,
        columnWidth: "25%",
        endingShape: "rounded",
        borderRadius: 5,
      },
    },
    colors: ["var(--bs-primary)", "var(--bs-secondary)"],
    dataLabels: {
      enabled: false,
    },
    yaxis: {
      show: true,
      min: 100,
      max: 400,
      tickAmount: 3,
    },
    stroke: {
      show: true,
      width: 5,
      lineCap: "butt",
      colors: ["transparent"],
    },
    xaxis: {
      type: "category",
      categories: ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat"],
      axisBorder: {
        show: false,
      },
    },
    fill: {
      opacity: 1,
    },
    tooltip: {
      theme: "dark",
    },
    legend: {
      show: false,
    },
  };

  var chart_column_basic = new ApexCharts(
    document.querySelector("#sales-overview"),
    options_sales_overview
  );
  chart_column_basic.render();


})