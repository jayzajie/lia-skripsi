/*
Template Name: Admin Template
Author: Wrappixel

File: js
*/
// ==============================================================
// Auto select left navbar
// ==============================================================
$(function () {
  "use strict";
  var url = window.location + "";
  var path = url.replace(
    window.location.protocol + "//" + window.location.host + "/",
    ""
  );
  var element = $("ul#sidebarnav a").filter(function () {
    return this.href === url || this.href === path; // || url.href.indexOf(this.href) === 0;
  });

  function findMatchingElement() {
    var currentUrl = window.location.href;
    var anchors = document.querySelectorAll("#sidebarnav a");
    for (var i = 0; i < anchors.length; i++) {
      if (anchors[i].href === currentUrl) {
        return anchors[i];
      }
    }

    return null; // Return null if no matching element is found
  }
  var elements = findMatchingElement();

  // Do something with the matching element
  if(elements){
    elements.classList.add("active");
  }

  document
    .querySelectorAll("ul#sidebarnav ul li a.active")
    .forEach(function (link) {
      link.closest("ul").classList.add("in");
      link.closest("ul").parentElement.classList.add("selected");
    });

  document.querySelectorAll("#sidebarnav li").forEach(function (li) {
    const isActive = li.classList.contains("selected");
    if (isActive) {
      const anchor = li.querySelector("a");
      if (anchor) {
        anchor.classList.add("active");
      }
    }
  });

  document.querySelectorAll("#sidebarnav a").forEach(function (link) {
    link.addEventListener("click", function (e) {
      const isActive = this.classList.contains("active");
      const parentUl = this.closest("ul");
      if (!isActive) {
        // hide any open menus and remove all other classes
        parentUl.querySelectorAll("ul").forEach(function (submenu) {
          submenu.classList.remove("in");
        });
        parentUl.querySelectorAll("a").forEach(function (navLink) {
          navLink.classList.remove("active");
        });

        // open our new menu and add the open class
        const submenu = this.nextElementSibling;
        if (submenu) {
          submenu.classList.add("in");
        }

        this.classList.add("active");
      } else {
        this.classList.remove("active");
        parentUl.classList.remove("active");
        const submenu = this.nextElementSibling;
        if (submenu) {
          submenu.classList.remove("in");
        }
      }
    });
  });

  // Create mobile sidebar toggle button
  function createMobileSidebarToggle() {
    // Create sidebar overlay
    const sidebarOverlay = document.createElement('div');
    sidebarOverlay.className = 'sidebar-overlay';
    document.body.appendChild(sidebarOverlay);
    
    // Create mobile toggle button if it doesn't exist
    if (!document.querySelector('.mobile-sidebar-toggle')) {
      const toggleButton = document.createElement('button');
      toggleButton.className = 'mobile-sidebar-toggle d-lg-none';
      toggleButton.innerHTML = '☰';
      toggleButton.setAttribute('aria-label', 'Toggle Sidebar');
      document.body.appendChild(toggleButton);
      
      toggleButton.addEventListener('click', function() {
        document.getElementById('main-wrapper').classList.add('sidebar-open');
      });
    }
    
    // Handle overlay click to close sidebar
    sidebarOverlay.addEventListener('click', function() {
      document.getElementById('main-wrapper').classList.remove('sidebar-open');
    });
  }
  
  // Run on page load
  createMobileSidebarToggle();
  
  // Mobile sidebar toggle
  const sidebarToggler = document.getElementById('sidebarCollapse');
  const pageWrapper = document.getElementById('main-wrapper');
  
  if (sidebarToggler) {
    sidebarToggler.addEventListener('click', function() {
      pageWrapper.classList.toggle('sidebar-open');
    });
  }
  
  // Close sidebar when clicking outside on mobile
  document.addEventListener('click', function(event) {
    const sidebar = document.querySelector('.left-sidebar');
    const sidebarToggler = document.getElementById('sidebarCollapse');
    const mobileToggler = document.querySelector('.mobile-sidebar-toggle');
    
    if (window.innerWidth <= 1199 && 
        pageWrapper.classList.contains('sidebar-open') && 
        !sidebar.contains(event.target) && 
        !sidebarToggler.contains(event.target) &&
        (!mobileToggler || !mobileToggler.contains(event.target))) {
      pageWrapper.classList.remove('sidebar-open');
    }
  });
  
  // Close sidebar when clicking on a menu item on mobile
  document.querySelectorAll('.sidebar-link').forEach(function(link) {
    link.addEventListener('click', function() {
      if (window.innerWidth <= 1199) {
        pageWrapper.classList.remove('sidebar-open');
      }
    });
  });
  
  // Handle window resize
  let resizeTimer;
  window.addEventListener('resize', function() {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(function() {
      if (window.innerWidth > 1199) {
        pageWrapper.classList.remove('sidebar-open');
      }
    }, 250);
  });
  
  // Add touch-friendly behavior for sidebar items
  if ('ontouchstart' in window) {
    document.querySelectorAll('.sidebar-link').forEach(function(link) {
      link.style.padding = '12px 15px';
    });
  }
});