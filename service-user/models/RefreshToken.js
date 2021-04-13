module.exports = (sequelize, DataTypes) => {
  const RefreshToken = sequelize.define(
    'RefreshToken',
    {
      id: {
        type: DataTypes.INTEGER,
        autoIncrement: true,
        allowNull: false,
        primaryKey: true,
      },
      token: {
        type: DataTypes.TEXT,
        allowNull: false,
      },
      user_id: {
        type: DataTypes.INTEGER,
        allowNull: false,
      },
      createdAt: {
        type: DataTypes.DATE,
        fields: 'created_at',
        allowNull: false,
      },
      updatedAt: {
        type: DataTypes.DATE,
        fields: 'updated_at',
        allowNull: false,
      },
    },
    {
      tabelName: 'refresh_token',
      timestamps: true,
    },
  );

  return RefreshToken;
};
