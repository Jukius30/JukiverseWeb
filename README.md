<p align="center">
  <a href="#" target="_blank">
    <img src="https://wallpapers.com/images/hd/minecraft-logo-transparent-background-1500-x-840-7itv6m80i910906h.png" width="400" alt="Minecraft Web Store Logo">
  </a>
</p>

<p align="center">
<a href="#"><img src="https://img.shields.io/badge/Maintained%3F-yes-green.svg" alt="Maintained"></a>
<a href="#"><img src="https://img.shields.io/badge/Payment-Midtrans-blue" alt="Midtrans"></a>
<a href="#"><img src="https://img.shields.io/badge/Integrations-Pterodactyl-orange" alt="Pterodactyl"></a>
</p>

## About This Project

This project is a high-performance, web-based purchase system specifically designed for Minecraft servers. It bridges the gap between payment processing and server automation, ensuring that players receive their items, ranks, or currency immediately after a successful checkout.

By leveraging **Midtrans** as the payment gateway and **Pterodactyl API** for server management, this system eliminates manual work for administrators and provides a seamless "Pay & Play" experience.

- **Automated Delivery**: Uses Pterodactyl's Client API to execute commands instantly.
- **Secure Payments**: Integrated with Midtrans Snap for secure and diverse payment options (QRIS, E-Wallet, VA).
- **Responsive UI**: A modern interface built to look great on both desktop and mobile devices.
- **Transaction History**: Comprehensive logs for both users and administrators to track orders.

## Core Integrations

### Midtrans Payment Gateway
We use Midtrans for its reliability in the Indonesian market. It supports:
- **E-Wallets**: GoPay, OVO, ShopeePay, Dana.
- **Virtual Accounts**: BCA, Mandiri, BNI, BRI.

### Pterodactyl API
The system communicates directly with your Pterodactyl panel to:
- Execute console commands in real-time.
- Manage player permissions via LuckPerms.

## Installation

1. **Clone the repository**:
   ```bash
   git clone [https://github.com/your-repo/minecraft-web-store.git](https://github.com/your-repo/minecraft-web-store.git)
