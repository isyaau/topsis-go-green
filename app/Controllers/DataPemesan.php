<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use \Myth\Auth\Models\UserModel;
use \Myth\Auth\Password;
use \Myth\Auth\Entities\User;
use \Myth\Auth\Authorization\GroupModel;

class DataPemesan extends BaseController
{
    protected $auth;

    protected $config;

    public function __construct()
    {
        $this->config = config('Auth');
        $this->auth = service('authentication');
    }

    public function index()
    {
        helper(['form']);
        $userModel = new UserModel();
        $data['users'] = $userModel->where('status', 2)->where('id !=', 0)->findAll();

        $groupModel = new GroupModel();

        foreach ($data['users'] as $row) {
            $dataRow['group'] = $groupModel->getGroupsForUser($row->id);
            $dataRow['row'] = $row;
            $data['row' . $row->id] = view('data_pemesan/row', $dataRow);
        }

        $data['groups'] = $groupModel->findAll();

        $data['title'] = 'Pemesan';
        $data['active'] = 'pemesan';
        $data['role'] = $groupModel->getGroupsForUser(user()->id);
        $data['config'] = $this->config;
        return view('data_pemesan/index', $data);
    }

    public function save()
    {
        $users = model(UserModel::class);

        $rules = [
            'fullname' => 'required|min_length[3]|max_length[30]',
            'username' => 'required|alpha_numeric_space|min_length[3]|max_length[30]|is_unique[users.username]',
            'email'    => 'required|valid_email|is_unique[users.email]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $rules = [
            'password'     => 'required|strong_password',
            'pass_confirm' => 'required|matches[password]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Save the user
        $allowedPostFields = array_merge(['password'], $this->config->validFields, $this->config->personalFields);
        $user = new User($this->request->getPost($allowedPostFields));

        $this->config->requireActivation === null ? $user->activate() : $user->generateActivateHash();

        // Ensure default group gets assigned if set
        if (!empty($this->config->defaultUserGroup)) {
            $users = $users->withGroup('user');
        }

        if (!$users->save($user)) {
            return redirect()->back()->withInput()->with('errors', $users->errors());
        }

        if ($this->config->requireActivation !== null) {
            $activator = service('activator');
            $sent = $activator->send($user);

            if (!$sent) {
                return redirect()->back()->withInput()->with('error', $activator->error() ?? lang('Auth.unknownError'));
            }

            // Success!
            return redirect()->to(base_url('/data-pemesan'));
        }

        // Success!
        return redirect()->to(base_url('/data-pemesan'));
    }

    public function delete($id)
    {
        // cari gambar berdaasarkan id
        $pemesan = $this->datapemesanModel->find($id);

        // cek jika gambar default-pemesan.png
        if ($pemesan['foto'] != 'default-avatar.jpg') {
            //hapus gambar
            unlink('img/' . $pemesan['foto']);
        }
        $groupModel = new GroupModel();
        $groupModel->removeUserFromAllGroups(intval($id));
        $this->datapemesanModel->delete($id);
        session()->setFlashdata('pesan', 'Data Berhasil Dihapus.');
        return redirect()->to('/data-pemesan');
    }

    public function edit($id)
    {
        $datapemesan = $this->datapemesanModel->getPemesan($id);
        if (empty($datapemesan)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data Mobil Tidak ditemukan !');
        }

        $pemesan = $this->datapemesanModel;
        $data = [
            'title' => 'Ubah Data Pemesan| SIA',
            'active'  => 'pemesan',
            'role' => $this->groups->getGroupsForUser(user()->id),
            'validation' => \Config\Services::validation(),
            'merk' => $this->datapemesanModel->getPemesan(),
            'datapemesan' => $this->datapemesanModel->getPemesan($id)

        ];
        return view('data_pemesan/edit', $data);
    }

    public function update($id)
    {
        $password = $this->request->getVar('password_hash');
        if ($password == "") {
            $passwordLama = $this->request->getVar('passwordLama');
            if (!$this->validate([
                'email' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Email Harus diisi',
                    ]
                ],
                'fullname' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'NamaHarus diisi',
                    ]
                ],
                'jenis_kelamin' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Jenis Kelamin Harus diisi',
                    ]
                ],
                'alamat' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Alamat Harus diisi',
                    ]
                ],
                'username' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Username Harus diisi',
                    ]
                ],
                'foto' => [
                    'rules' => 'is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/gif,image/png]|max_size[foto,2048]',
                    'errors' => [
                        'is_image' => 'File yang anda upload bukan gambar',
                        'mime_in' => 'File Extention Harus Berupa jpg,jpeg,gif,png',
                        'max_size' => 'Ukuran File Maksimal 2 MB'
                    ]
                ]

            ])) {
                session()->setFlashdata('error', $this->validator->listErrors());
                return redirect()->back()->withInput();
            }


            // ambil gambar
            $fileFoto = $this->request->getFile('foto');
            $fotoLama = $this->request->getVar('fotoLama');

            //apakah tidak ada gambar yang diupload
            if ($fileFoto->getError() == 4) {
                $namaFoto = $this->request->getVar('fotoLama');
            } elseif ($fotoLama == 'default-avatar.jpg') {
                //generate nama gambar

                $namaFoto = $fileFoto->getRandomName();
                // pindahkan file ke folder img

                $fileFoto->move('img', $namaFoto);
            } else {
                //generate nama gambar

                $namaFoto = $fileFoto->getRandomName();
                // pindahkan file ke folder img
                $fileFoto->move('img', $namaFoto);
                // hapus file nama
                unlink('img/' . $this->request->getVar('fotoLama'));
            }

            $this->datapemesanModel->save([
                'id' => $id,
                'email' => $this->request->getVar('email'),
                'fullname' => $this->request->getVar('fullname'),
                'jenis_kelamin' => $this->request->getVar('jenis_kelamin'),
                'alamat' => $this->request->getVar('alamat'),
                'username' => $this->request->getVar('username'),
                'password' => $passwordLama,
                'foto' => $namaFoto

            ]);
        } else {
            if (!$this->validate([
                'email' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Email Harus diisi',
                    ]
                ],
                'fullname' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'NamaHarus diisi',
                    ]
                ],
                'jenis_kelamin' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Jenis Kelamin Harus diisi',
                    ]
                ],
                'alamat' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Alamat Harus diisi',
                    ]
                ],
                'username' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Username Harus diisi',
                    ]
                ],
                'password' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Password Harus diisi'

                    ]
                ],
                'confpassword' => [
                    'rules' => 'matches[password]',
                    'errors' => [
                        'matches' => 'Konfirmasi password tidak cocok'
                    ]
                ],
                'foto' => [
                    'rules' => 'is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/gif,image/png]|max_size[foto,2048]',
                    'errors' => [
                        'is_image' => 'File yang anda upload bukan gambar',
                        'mime_in' => 'File Extention Harus Berupa jpg,jpeg,gif,png',
                        'max_size' => 'Ukuran File Maksimal 2 MB'
                    ]
                ]

            ])) {
                session()->setFlashdata('error', $this->validator->listErrors());
                return redirect()->back()->withInput();
            }
            // ambil gambar
            $fileFoto = $this->request->getFile('foto');
            $fotoLama = $this->request->getVar('fotoLama');

            //apakah tidak ada gambar yang diupload
            if ($fileFoto->getError() == 4) {
                $namaFoto = $this->request->getVar('fotoLama');
            } elseif ($fotoLama == 'default-avatar.png') {
                //generate nama gambar

                $namaFoto = $fileFoto->getRandomName();
                // pindahkan file ke folder img

                $fileFoto->move('img', $namaFoto);
            } else {
                //generate nama gambar

                $namaFoto = $fileFoto->getRandomName();
                // pindahkan file ke folder img

                $fileFoto->move('img', $namaFoto);
                // hapus file nama
                unlink('img/' . $this->request->getVar('fotoLama'));
            }

            $this->datapemesanModel->save([
                'id' => $id,
                'email' => $this->request->getVar('email'),
                'fullname' => $this->request->getVar('fullname'),
                'jenis_kelamin' => $this->request->getVar('jenis_kelamin'),
                'alamat' => $this->request->getVar('alamat'),
                'username' => $this->request->getVar('username'),
                'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
                'foto' => $namaFoto

            ]);
        }
        session()->setFlashdata('pesan', 'Ubah Data Akun Berhasil');
        return redirect()->to('/data-pemesan');
    }
    public function detail($id)
    {
        $datapemesan = $this->datapemesanModel->getPemesan($id);
        if (empty($datapemesan)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data Mobil Tidak ditemukan !');
        }

        $akun = $this->datapemesanModel;
        $data = [
            'title' => 'Ubah Data Akun| SIA',
            'active'  => 'pemesan',
            'role' => $this->groups->getGroupsForUser(user()->id),
            'validation' => \Config\Services::validation(),
            'merk' => $this->datapemesanModel->getPemesan(),
            'datapemesan' => $this->datapemesanModel->getPemesan($id)

        ];
        return view('data_pemesan/detail', $data);
    }

    public function activate()
    {
        $userModel = new UserModel();

        $data = [
            'activate_hash' => null,
            'active' => $this->request->getVar('active') == '0' || '' ? '1' : '0',
        ];
        $userModel->update($this->request->getVar('id'), $data);

        return redirect()->to(base_url('/data-pemesan'));
    }

    public function changePassword($id = null)
    {
        if ($id == null) {
            return redirect()->to(base_url('/data-pemesan'));
        } else {
            $data = [
                'id' => $id,
                'title' => 'Update Password',
            ];
            return view('data_pemesan/set_password', $data);
        }
    }

    public function setPassword()
    {
        $id = $this->request->getVar('id');
        $rules = [
            'password'     => 'required|strong_password',
            'pass_confirm' => 'required|matches[password]',
        ];

        if (!$this->validate($rules)) {
            $data = [
                'id' => $id,
                'title' => 'Update Password',
                'validation' => $this->validator,
            ];

            return view('data_pemesan/set_password', $data);
        } else {
            $userModel = new UserModel();
            $data = [
                'password_hash' => Password::hash($this->request->getVar('password')),
                'reset_hash' => null,
                'reset_at' => null,
                'reset_expires' => null,
            ];
            $userModel->update($this->request->getVar('id'), $data);

            return redirect()->to(base_url('/data-pemesan'));
        }
    }

    public function changeGroup()
    {
        $userId = $this->request->getVar('id');
        $groupId = $this->request->getVar('group');

        $groupModel = new GroupModel();
        $groupModel->removeUserFromAllGroups(intval($userId));

        $groupModel->addUserToGroup(intval($userId), intval($groupId));
        $userModel = new UserModel();

        $data = [
            'status' => $groupId,
        ];
        $userModel->update($this->request->getVar('id'), $data);

        return redirect()->to(base_url('/data-pemesan'));
    }


    public function setting($id)
    {
        $datapemesan = $this->datapemesanModel->getPemesan($id);
        if (empty($datapemesan)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data Mobil Tidak ditemukan !');
        }

        $pemesan = $this->datapemesanModel;
        $data = [
            'title' => 'Ubah Data Pemesan| SIA',
            'active'  => 'setting',
            'role' => $this->groups->getGroupsForUser(user()->id),
            'validation' => \Config\Services::validation(),
            'merk' => $this->datapemesanModel->getPemesan(),
            'datapemesan' => $this->datapemesanModel->getPemesan($id)

        ];
        return view('setting', $data);
    }

    public function upset($id)
    {
        $password = $this->request->getVar('password_hash');
        if ($password == "") {
            $passwordLama = $this->request->getVar('passwordLama');
            if (!$this->validate([
                'email' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Email Harus diisi',
                    ]
                ],
                'fullname' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'NamaHarus diisi',
                    ]
                ],
                'jenis_kelamin' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Jenis Kelamin Harus diisi',
                    ]
                ],
                'alamat' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Alamat Harus diisi',
                    ]
                ],
                'username' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Username Harus diisi',
                    ]
                ],
                'foto' => [
                    'rules' => 'is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/gif,image/png]|max_size[foto,2048]',
                    'errors' => [
                        'is_image' => 'File yang anda upload bukan gambar',
                        'mime_in' => 'File Extention Harus Berupa jpg,jpeg,gif,png',
                        'max_size' => 'Ukuran File Maksimal 2 MB'
                    ]
                ]

            ])) {
                session()->setFlashdata('error', $this->validator->listErrors());
                return redirect()->back()->withInput();
            }


            // ambil gambar
            $fileFoto = $this->request->getFile('foto');
            $fotoLama = $this->request->getVar('fotoLama');

            //apakah tidak ada gambar yang diupload
            if ($fileFoto->getError() == 4) {
                $namaFoto = $this->request->getVar('fotoLama');
            } elseif ($fotoLama == 'default-avatar.jpg') {
                //generate nama gambar

                $namaFoto = $fileFoto->getRandomName();
                // pindahkan file ke folder img

                $fileFoto->move('img', $namaFoto);
            } else {
                //generate nama gambar

                $namaFoto = $fileFoto->getRandomName();
                // pindahkan file ke folder img
                $fileFoto->move('img', $namaFoto);
                // hapus file nama
                unlink('img/' . $this->request->getVar('fotoLama'));
            }

            $this->datapemesanModel->save([
                'id' => $id,
                'email' => $this->request->getVar('email'),
                'fullname' => $this->request->getVar('fullname'),
                'jenis_kelamin' => $this->request->getVar('jenis_kelamin'),
                'alamat' => $this->request->getVar('alamat'),
                'username' => $this->request->getVar('username'),
                'password' => $passwordLama,
                'foto' => $namaFoto

            ]);
        } else {
            if (!$this->validate([
                'email' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Email Harus diisi',
                    ]
                ],
                'fullname' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'NamaHarus diisi',
                    ]
                ],
                'jenis_kelamin' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Jenis Kelamin Harus diisi',
                    ]
                ],
                'alamat' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Alamat Harus diisi',
                    ]
                ],
                'username' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Username Harus diisi',
                    ]
                ],
                'password' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Password Harus diisi'

                    ]
                ],
                'confpassword' => [
                    'rules' => 'matches[password]',
                    'errors' => [
                        'matches' => 'Konfirmasi password tidak cocok'
                    ]
                ],
                'foto' => [
                    'rules' => 'is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/gif,image/png]|max_size[foto,2048]',
                    'errors' => [
                        'is_image' => 'File yang anda upload bukan gambar',
                        'mime_in' => 'File Extention Harus Berupa jpg,jpeg,gif,png',
                        'max_size' => 'Ukuran File Maksimal 2 MB'
                    ]
                ]

            ])) {
                session()->setFlashdata('error', $this->validator->listErrors());
                return redirect()->back()->withInput();
            }
            // ambil gambar
            $fileFoto = $this->request->getFile('foto');
            $fotoLama = $this->request->getVar('fotoLama');

            //apakah tidak ada gambar yang diupload
            if ($fileFoto->getError() == 4) {
                $namaFoto = $this->request->getVar('fotoLama');
            } elseif ($fotoLama == 'default-avatar.png') {
                //generate nama gambar

                $namaFoto = $fileFoto->getRandomName();
                // pindahkan file ke folder img

                $fileFoto->move('img', $namaFoto);
            } else {
                //generate nama gambar

                $namaFoto = $fileFoto->getRandomName();
                // pindahkan file ke folder img

                $fileFoto->move('img', $namaFoto);
                // hapus file nama
                unlink('img/' . $this->request->getVar('fotoLama'));
            }

            $this->datapemesanModel->save([
                'id' => $id,
                'email' => $this->request->getVar('email'),
                'fullname' => $this->request->getVar('fullname'),
                'jenis_kelamin' => $this->request->getVar('jenis_kelamin'),
                'alamat' => $this->request->getVar('alamat'),
                'username' => $this->request->getVar('username'),
                'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
                'foto' => $namaFoto

            ]);
        }
        session()->setFlashdata('pesan', 'Ubah Data Akun Berhasil');
        return redirect()->to('/dashboard');
    }
}
