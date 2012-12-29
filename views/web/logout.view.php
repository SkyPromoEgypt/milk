<?php
unset($_SESSION['loggedIn']);
unset($_SESSION['user']);
header("Location: /");