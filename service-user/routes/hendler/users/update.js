const bcrypt = require('bcrypt');
const {User} = require('../../../models');
const Validator = require('fastest-validator');
const v = new Validator();

module.exports = async (req, res) => {
  const schema = {
    name: 'string|empty:false',
    email: 'email|empty:false',
    password: 'string|min:6',
    profession: 'string|optional',
    avatar: 'string|optional',
  };
  const validate = v.validate(req.body, schema);

  if (validate.length) {
    return res.status(400).json({status: 'error', message: validate});
  }

  const id = req.params.id;
  const user = await User.findByPk(id);

  if (!user) {
    return res
      .status(404)
      .json({status: 'error', message: 'user Tidak Tersedia'});
  }

  const email = req.body.email;

  if (email) {
    const cekEmail = await User.findOne({where: {email: email}});

    if (cekEmail && email !== user.email) {
      return res
        .status(409)
        .json({status: 'error', message: 'Email Telah Tersedia'});
    }
  }

  const password = await bcrypt.hash(req.body.password, 10);

  const {name, profession, avatar} = req.body;

  await user.update({
    email: email,
    password: password,
    name: name,
    profession: profession,
    avatar: avatar,
  });

  return res.json({
    status: 'success',
    data: {
      id: user.id,
      name: user.name,
      email: user.email,
      avatar: user.avatar,
      profession: user.profession,
      role: user.role,
    },
  });
};
