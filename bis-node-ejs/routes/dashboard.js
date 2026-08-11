const express = require('express');
const router = express.Router();

const roleMenu = {
  secretary: [
    { icon: 'fas fa-tachometer-alt', label: 'Dashboard', key: 'dashboard', href: '/secretary/dashboard' },
    { icon: 'fas fa-users', label: 'Census Records', key: 'census', href: '/secretary/census' },
    { icon: 'fas fa-robot', label: 'Chatbot Logs', key: 'chatbot', href: '/secretary/chatbot' },
    { icon: 'fas fa-file-alt', label: 'Clearance', key: 'clearance', href: '/secretary/clearance' },
    { icon: 'fas fa-book', label: 'Blotter Reports', key: 'blotter', href: '/secretary/blotter' },
    { icon: 'fas fa-chart-bar', label: 'Reports', key: 'reports', href: '/secretary/reports' },
    { icon: 'fas fa-user-clock', label: 'Pending Accounts', key: 'pending_accounts', href: '/secretary/pending_accounts' },
    { icon: 'fas fa-user-plus', label: 'Create Official', key: 'create_account', href: '/secretary/create_account' }
  ],
};

const pages = {
  dashboard: { title: 'Secretary Dashboard', view: 'secretary/dashboard' },
  census: { title: 'Census Records', view: 'secretary/census' },
  chatbot: { title: 'Chatbot Logs', view: 'secretary/chatbot' },
  clearance: { title: 'Clearance Management', view: 'secretary/clearance' },
  blotter: { title: 'Blotter Reports', view: 'secretary/blotter' },
  reports: { title: 'Reports', view: 'secretary/reports' },
  pending_accounts: { title: 'Pending Accounts', view: 'secretary/pending_accounts' },
  create_account: { title: 'Create Official Account', view: 'secretary/create_account' },
  settings: { title: 'Settings', view: 'secretary/settings' }
};

const sampleData = {
  census: {
    filters: { search: '', zone: '', gender: '', age_min: '', age_max: '' },
    totalHouseholds: 862,
    totalMale: 452,
    totalFemale: 410,
    pwds: 28,
    fourPs: 114,
    seniors: 82,
    soloParent: 33,
    households: [
      { id: '20014', head: 'Juan Dela Cruz', zone: 'Zone 1', members: 5, status: 'Active' },
      { id: '20015', head: 'Maria Santos', zone: 'Zone 3', members: 4, status: 'Active' },
      { id: '20016', head: 'Pedro Reyes', zone: 'Zone 5', members: 6, status: 'Inactive' },
    ]
  },
  chatbot: {
    logs: [
      { id: '001', resident: 'Juan Dela Cruz', topic: 'Clearance', preview: 'How do I apply for barangay clearance?', date: 'May 21, 2026', status: 'Resolved' },
      { id: '002', resident: 'Maria Santos', topic: 'Census', preview: 'How do I update my household information?', date: 'May 20, 2026', status: 'Resolved' },
      { id: '003', resident: 'Pedro Reyes', topic: 'General', preview: 'What are the office hours?', date: 'May 18, 2026', status: 'Pending' }
    ]
  },
  clearance: {
    pending: 14,
    approved: 92,
    rejected: 7,
    total: 113,
    residents: [
      { name: 'Ana Gomez', zone: 'Zone 2', requests: 3, pending: 1, approved: 1, rejected: 1, latest: 'May 19, 2026', user_id: 801 },
      { name: 'Carlos Lim', zone: 'Zone 4', requests: 5, pending: 2, approved: 2, rejected: 1, latest: 'May 20, 2026', user_id: 802 }
    ]
  },
  dashboard: {
    stats: [
      { icon: 'fas fa-users', label: 'Residents', value: 526 },
      { icon: 'fas fa-home', label: 'Households', value: 210 },
      { icon: 'fas fa-file-alt', label: 'Pending Requests', value: 37 },
      { icon: 'fas fa-chart-line', label: 'Reports This Month', value: 14 }
    ]
  }
};

router.get('/', (req, res) => res.redirect('/secretary/dashboard'));

router.get('/:role/:page', (req, res) => {
  const { role, page } = req.params;
  if (!['secretary'].includes(role)) {
    return res.status(404).render('404', { url: req.originalUrl });
  }

  const config = pages[page];
  if (!config) {
    return res.status(404).render('404', { url: req.originalUrl });
  }

  res.render(config.view, {
    role,
    active: page,
    pageTitle: config.title,
    menuItems: roleMenu[role],
    data: sampleData[page] || {},
    currentUrl: req.originalUrl
  });
});

module.exports = router;
