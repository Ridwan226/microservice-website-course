'use strict';
const bycrpt = require('bcrypt');

module.exports = {
  up: async (queryInterface, Sequelize) => {
    await queryInterface.bulkInsert(
      'users',
      [
        {
          name: 'Ridwan',
          profession: 'predisent',
          role: 'admin',
          email: 'ridwan@mail.com',
          password: await bycrpt.hash('1234qwer', 10),
          created_at: new Date(),
          updated_at: new Date(),
        },
        {
          name: 'Ridwan Ganteng',
          profession: 'Wakil predisent',
          role: 'student',
          email: 'ridwan@gmail.com',
          password: await bycrpt.hash('1234qwer', 10),
          created_at: new Date(),
          updated_at: new Date(),
        },
      ],
      {},
    );
  },

  down: async (queryInterface, Sequelize) => {
    await queryInterface.bulkDelete('users', null, {});
  },
};
