const {User, RefreshToken} = require('../../../models');

const Validator = require('fastest-validator');

const v = new Validator();

module.exports = async (req, res) => {
  const userId = req.body.user_id;
  const tokenRefresh = req.body.refresh_token;

  const schema = {
    refresh_token: 'string',
    user_id: 'number',
  };

  const validated = v.validate(req.body, schema);

  if (!validated) {
    return res.status(400).json({status: 'error', message: validate});
  }

  const user = await User.findByPk(userId);

  if (!user) {
    return res.status(404).json({status: 'error', message: 'user not found'});
  }

  const data = {
    token: tokenRefresh,
    user_id: userId,
  };

  const createdRefreshToken = await RefreshToken.create(data);

  return res.status(200).json({status: 'succes', data: createdRefreshToken.id});
};
