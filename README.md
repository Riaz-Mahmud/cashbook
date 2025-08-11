# CashBook

**CashBook** is a free, open-source cash management web application for individuals and businesses. Easily track your cash flow, manage multiple businesses, and generate insightful reports—all with no subscription or hidden fees.

## Features

- Multi-business support: manage unlimited businesses from one account
- Multiple cash books per business
- Track income and expenses with categories
- Transaction management with receipt uploads
- Dashboard and analytics for your finances
- User roles and permissions
- Secure authentication and account management
- PDF export and reporting
- Modern, responsive UI

## Technologies Used
- **Backend**: Laravel 10
- **Frontend**: Vue.js, Bootstrap 5
- **Database**: MySQL
- **Authentication**: Laravel Sanctum
- **Storage**: Local file storage for receipts
- **Development Tools**: Composer, NPM, Webpack
- **Testing**: PHPUnit, Laravel Dusk

## Getting Started

1. Clone the repository:
   ```bash
   git clone https://github.com/Riaz-Mahmud/cashbook.git
   cd cashbook
    ```

2. Install dependencies:
   ```bash
   composer install
   npm install && npm run build
    ```

3. Copy the example environment file:
   ```bash
   cp .env.example .env
   php artisan key:generate
    ```

4. Run migrations and seed the database:
   ```bash
   php artisan migrate --seed
   ```



## Contributing
CashBook is open source and welcomes contributions! If you have ideas, bug fixes, or new features, please open an issue or submit a pull request.
- Fork the repository
- Create your feature branch (git checkout -b feature/YourFeature)
- Commit your changes (git commit -am 'Add some feature')
- Push to the branch (git push origin feature/YourFeature)
- Open a pull request

## License
CashBook is licensed under the [MIT License](https://opensource.org/license/mit/).

## Authors
- [Riaz Mahmud](https://github.com/Riaz-Mahmud) - Initial work

## Acknowledgements
- [Laravel](https://laravel.com) for the powerful PHP framework
- [Vue.js](https://vuejs.org) for the modern JavaScript framework
- [Bootstrap](https://getbootstrap.com) for the responsive design
