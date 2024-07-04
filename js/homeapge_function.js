  // JavaScript code for toggling active class on sidebar links
  document.addEventListener('DOMContentLoaded', () => {
    const sidebarLinks = document.querySelectorAll('.sidebar-link');
    sidebarLinks.forEach(link => {
      link.addEventListener('click', () => {
        sidebarLinks.forEach(l => l.classList.remove('active'));
        link.classList.add('active');
        if (link.id === 'dashboard-link') {
          document.getElementById('announcement-section').style.display = 'block';
        } else {
          document.getElementById('announcement-section').style.display = 'none';
        }
      });
    });
  });