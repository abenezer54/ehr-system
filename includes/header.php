<style>
li {
  list-style: none;
}

header a {

  text-decoration: none;
  color: #fff;
  font-size: 1rem;
}

header a:hover {
  color: #00eaff;
}

header {
  width: 100%;
  position: relative;
  padding: 0 2rem;
  background-color:#002B5C;
}

.navbar {
  width: 100%;
  height: 60px;
  max-width: 1200px;
  margin: 0 auto;
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.navbar .logo a {
  font-size: 1.5rem;
  font-weight: bold;
}

.navbar .nav ul {
  display: flex;
  gap: 2rem;
  align-items: center;
  margin-left: auto;
  margin-right: 0;
}

.navbar .menu {
  color: #fff;
  font-size: 1.5rem;
  cursor: pointer;
  display: none;
}

.navbar .highlight {
  display: block;
  margin-left: 0;
  margin-right: 1rem;
}

.highlight {
  background-color: #0f8577;
  color: #fff;
  padding: 0.5rem 1rem;
  border: none;
  outline: none;
  border-radius: 20px;
  font-size: 0.8rem;
  font-weight: bold;
  cursor: pointer;
  transition: scale 0.2s ease;
  align-items: center;
  justify-content: center;
  text-align: center;
  margin: 0 auto;
}

.highlight:hover {
  transform: scale(1.05);
  color: #000;
}

.highlight:active {
  transform: scale(0.95);
}

.dropdown-menu {
  position: absolute;
  top: 60px;
  width: 250px;
  height: 0;
  background: rgba(255, 255, 255, 0.1);
  backdrop-filter: blur(15px);
  border-radius: 10px;
  overflow: hidden;
  display: none;
}

.dropdown-menu li {
  padding: 0.7rem;
  display: flex;
  align-items: center;
  justify-content: center;
}

.dropdown-menu .highlight {
  width: 80%;
  display: flex;
  justify-content: center;
}

.dropdown-menu.open {
  height: 325px;
  width: 100%;
  max-width: 100%;
  left: 0;
  right: 0;
}

.header-container {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  text-align: center;
  height: 100vh;
  background-color: transparent;
}

/* Nav Bar Ends */

/* Responsive */

@media (max-width: 992px) {
  .navbar .nav ul {
    display: none;
  }

  .navbar .menu {
    display: flex;
  }

  .navbar .menu i {
    display: inline-block;
  }

  .navbar .highlight {
    display: none;
  }

  .dropdown-menu {
    display: block;
  }

  .dropdown-menu .highlight {
    display: block;
    margin-top: 1rem;
  }
}
</style>
<header>
    <div class="navbar">
        <div class="logo">
            <a href="/ehr-system">Home</a>
        </div>
     
        <a href="/ehr-system/logout.php" class="highlight">Logout</a>
 
    </div>
</header>
