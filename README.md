# PortaPack Mayhem Custom Apps & Web Repository

Welcome to the custom repository for HackRF PortaPack (Mayhem Firmware) standalone applications! 

This project serves as a community-driven hub for custom `.ppmp` apps—ranging from games and utilities to highly realistic prank animations. Alongside the applications, this repository also includes a fully functional, secure, and responsive **PHP Web Storefront** (`index.php`), allowing anyone to easily host and display this app repository on their own web server.


## Hosted

https://ppapps.creativo.hu

---

## 📁 Repository Structure

To ensure the web storefront dynamically reads and displays the apps correctly, the files must be strictly organized in the following structure:

```text
.
├── index.php                 # The Web Storefront script
└── apps/                     # Root folder for all applications
    ├── Games/                # Category name (Folder)
    │   ├── jdriller.ppmp      # The executable Mayhem app
    │   ├── jdriller.txt       # Description of the app
    │   ├── jdriller.jpg       # App screenshot (or .png)
    │   └── jdriller_1.jpg     # Additional screenshot (optional)
    └── Pranks/               # Another Category
        ├── jstarlink.ppmp
        ├── jstarlink.txt
        └── jstarlink.png
```

# 🤝 How to Add Your Own Apps (Contributing)
We highly encourage community contributions! If you have developed a custom standalone Mayhem application and want to share it, you can easily add it to this repository.

To get your app featured, please submit a Pull Request (PR) following these strict formatting rules:

Fork the Repository: Start by forking this repo to your own GitHub account.

Choose or Create a Category: Navigate to the apps/ folder. You can place your app in an existing category folder (e.g., Games, Utilities) or create a new folder for a new category.

Upload the Executable: Add your compiled .ppmp file to the category folder.

Add a Description: Create a .txt file with the exact same base name as your app (e.g., if your app is myhack.ppmp, create myhack.txt). Write a brief, clear description of what your app does inside this text file.

Add Screenshots: You must include at least one screenshot of your app in action.

Name it to match your app: myhack.jpg or myhack.png.

If you want to include a swipeable gallery of multiple images, add a numbered suffix: myhack_1.jpg, myhack_2.png, etc.

Submit your PR: Once your files are correctly named and placed, commit your changes and submit a Pull Request to the main branch.

Note: The PHP storefront automatically reads this folder structure, so if you name your files correctly, your app will instantly appear on the website with its description and image gallery once merged!

Never upload harmful apps!


# ⚠️ Disclaimer
The "Hack" tools included in this repository (e.g., Starlink, Door Unlock) are strictly PRANK applications. They do not transmit malicious RF signals, they do not brute-force real AES keys, and they do not interact with actual infrastructure. They are UI mockups designed for entertainment and educational purposes only.

The developer assumes no responsibility for any misunderstandings, panic, or consequences arising from the use of these prank applications in public or restricted areas. Use common sense!

