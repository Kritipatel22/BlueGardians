// ====== Simple Auth using localStorage ======
// Data shape:
// localStorage["users"] = JSON.stringify([{ name, email, password }])
// localStorage["currentUserEmail"] = "user@example.com"

function getUsers() {
  try { return JSON.parse(localStorage.getItem("users")) || []; }
  catch { return []; }
}

function saveUsers(users) {
  localStorage.setItem("users", JSON.stringify(users));
}

function getCurrentUser() {
  const email = localStorage.getItem("currentUserEmail");
  if (!email) return null;
  const users = getUsers();
  return users.find(u => u.email === email) || null;
}

function setCurrentUser(email) {
  localStorage.setItem("currentUserEmail", email);
}

function clearCurrentUser() {
  localStorage.removeItem("currentUserEmail");
}

// Sign Up handler
function handleSignup(e) {
  e.preventDefault();
  const name = document.getElementById("name").value.trim();
  const email = document.getElementById("email").value.trim().toLowerCase();
  const password = document.getElementById("password").value;

  const users = getUsers();

  // Prevent duplicate emails
  if (users.some(u => u.email === email)) {
    alert("An account with this email already exists. Please log in.");
    window.location.href = "login.html";
    return;
  }

  users.push({ name, email, password }); // NOTE: plain-text (OK for demo/hackathon)
  saveUsers(users);
  setCurrentUser(email);

  alert("🎉 Account created! You're now signed in.");
  window.location.href = "index.html";
}

// Login handler
function handleLogin(e) {
  e.preventDefault();
  const email = document.getElementById("loginEmail").value.trim().toLowerCase();
  const password = document.getElementById("loginPassword").value;

  const user = getUsers().find(u => u.email === email && u.password === password);
  if (!user) {
    alert("❌ Invalid email or password");
    return;
  }

  setCurrentUser(email);
  alert(`✅ Welcome back, ${user.name}!`);
  window.location.href = "index.html";
}

// Logout
function logout() {
  clearCurrentUser();
  alert("👋 Logged out");
  // After logout, send to homepage (or stay)
  window.location.href = "index.html";
}

// Update navbar UI on each page
function updateAuthUI() {
  const signBtn = document.querySelector(".sign-in-btn");
  const current = getCurrentUser();

  if (!signBtn) return;

  if (current) {
    // Turn "Sign In" into "Logout"
    signBtn.textContent = "Logout";
    signBtn.setAttribute("href", "#");
    signBtn.onclick = (e) => { e.preventDefault(); logout(); };

    // Add a small "Hi, Name" badge near the button
    let badge = document.getElementById("welcome-badge");
    if (!badge) {
      badge = document.createElement("span");
      badge.id = "welcome-badge";
      badge.style.marginLeft = "10px";
      badge.style.fontWeight = "600";
      badge.style.color = "#4A90B8";
      signBtn.parentNode.insertBefore(badge, signBtn);
    }
    badge.textContent = `Hi, ${current.name} 👋`;
  } else {
    // Ensure button routes to login
    signBtn.textContent = "Sign In";
    signBtn.setAttribute("href", "login.html");
    const badge = document.getElementById("welcome-badge");
    if (badge) badge.remove();
  }
}

// Attach form listeners when present
document.addEventListener("DOMContentLoaded", () => {
  const signupForm = document.getElementById("signupForm");
  if (signupForm) signupForm.addEventListener("submit", handleSignup);

  const loginForm = document.getElementById("loginForm");
  if (loginForm) loginForm.addEventListener("submit", handleLogin);

  updateAuthUI();
});


const joinBtn = document.getElementById("joinBtn");
if (joinBtn) {
  joinBtn.addEventListener("click", (e) => {
    e.preventDefault();
    const user = getCurrentUser();

    if (user) {
      // Already logged in → take them to quiz
      window.location.href = "Mangrove/index.html";
    } else {
      // Not logged in → ask to login first
      alert("⚠️ Please sign in first to join the mission!");
      window.location.href = "login.html";
    }
  });
}

