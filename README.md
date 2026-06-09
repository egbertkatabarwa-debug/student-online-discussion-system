# student-online-discussion-system
These system aimed to help student to discuss and share knowledges online from different locations, areas and home places


System Interface Overview
Based on the operational flow of the system, the application is divided into five core stages:
Login & Remote Gateways: A secure portal authentication dashboard coupled with an integrated PeerJS infrastructure. 
Remote students can instantly connect to a live session by exchanging global connection IDs.
Group Discussion Registration: An adjustable registry interface where hosts set the total member count to instantly fetch and generate clean, dynamic data entry fields capturing student names and localized WhatsApp connectivity tags.
Seating Layout Workspace: A visual representation mapping out real-time digital collaboration. Registered students are assigned distinct seating tiles arrayed around a central virtual oval discussion table.
Live Interactive Forums: A monitored classroom simulation including live phase transitions, an active countdown timer displaying the speaker's remaining floor time, and prominent glowing pulse indicators around the current speaker's seating tile.
Session Control Modules: Master operational controls that allow active speakers to toggle microphone access streams (Start Speaking) or seamlessly bridge into external face-to-face video utilities (WhatsApp Video Call).


Key feachers
Visual Virtual Classroom Grid: Simulates a realistic boardroom seating chart where students occupy distinct, reactive nodes arranged around a central Discussion Table.
PeerJS WebRTC Remote Connectivity: Enables real-time, peer-to-peer data synchronization and audio capabilities across remote devices using uniquely generated connection UUIDs.
Role-Based Turn Management: Supports structured classroom hierarchies, explicitly provisioning roles such as Chair Person, Vice Chair Person, and sequential members.
Active Speaker Detection: Dynamically updates the UI to isolate the active contributor using distinct CSS glowing animations (@keyframes pulse) and highlighted tile state colors.
IntegraFrontend UI Architecture: HTML5, CSS3 (Flexbox, Grid CSS for responsive table layouts, custom CSS keyframe animations).
Client-Side Real-Time Engine: Vanilla JavaScript (ES6+), PeerJS CDN (peerjs.min.js) utilizing native WebRTC protocols.
Backend Processing API: Asynchronous Fetch API routing to an externalized api.php module for verification routines.
Database Management: MySQL (integrated via the PHP API backend layer to handle user creation and sign-in validation).ted Communication Shortcuts: Embedded action workflows to initiate micro-level browser stream captures (Use Mic) or instantiate cross-platform routing (WhatsApp Video Call).


Tech Stack
Frontend UI Architecture: HTML5, CSS3 (Flexbox, Grid CSS for responsive table layouts, custom CSS keyframe animations).
Client-Side Real-Time Engine: Vanilla JavaScript (ES6+), PeerJS CDN (peerjs.min.js) utilizing native WebRTC protocols.
Backend Processing API: Asynchronous Fetch API routing to an externalized api.php module for verification routines.
Database Management: MySQL (integrated via the PHP API backend layer to handle user creation and sign-in validation).


File Directory Framework
To run this platform efficiently, ensure your local directory environment contains the following structured components:
Student-Online-Discussion-system/
├── index.html       # Main application interface, CSS layout rules, and WebRTC signaling logic.
├── api.php          # Backend control gateway routing database transactions (Login/Signup).
└── README.md        # Technical execution documentation and platform blueprint.

Local Deployment Blueprint
To host and test this application locally using a standard web development stack (such as XAMPP, WampServer, or a configured PHP/Apache environment):
1. Environment Setup
Clone or place the system repository files into your local server web root folder
(e.g., C:/xampp/htdocs/Student-Online-Discussion-system/).
3. Configure Your Database
Ensure your MySQL environment includes a user table optimized to evaluate incoming JSON packets sent from the frontend sign-in forms:

CREATE DATABASE student_hub;
USE student_hub;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fullname VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL
);

Initialize the Local Host Server
Spin up your Apache and MySQL service nodes via your server control dashboard.
Open a modern, secure web browser instance.
Navigate directly to your local development address:
[![Open UI](https://img.shields.io/badge/Launch-Discussion%20Hub-008b8b?style=for-the-badge&logo=rocket)](https://egbertkatabarwa-debug.github.io/student-online-discussion-system/index.html)
