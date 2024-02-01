<?php

namespace App\Controllers;

use CodeIgniter\Validation\Validation;
use CodeIgniter\Controller;
use \Myth\Auth\Models\UserModel;
use \Myth\Auth\Password;
use \Myth\Auth\Entities\User;
use \Myth\Auth\Authorization\GroupModel;
use \Myth\Auth\Config\Auth as AuthConfig;

class DataAkun extends BaseController
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
        // session();
        helper(['form']);
        $userModel = new UserModel();
        $data['users'] = $userModel->where('status', 1)->findAll();

        $groupModel = new GroupModel();

        foreach ($data['users'] as $row) {
            $dataRow['group'] = $groupModel->getGroupsForUser($row->id);
            $dataRow['row'] = $row;
            $data['row' . $row->id] = view('data_akun/row', $dataRow);
        }

        $data['groups'] = $groupModel->findAll();

        $data['title'] = 'Users';
        $data['active'] = 'akun';
        $data['role'] = $groupModel->getGroupsForUser(user()->id);
        $data['config'] = $this->config;
        return view('data_akun/index', $data);
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
            $users = $users->withGroup('administrator');
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
            return redirect()->to(base_url('/data-akun'));
        }

        // Success!
        return redirect()->to(base_url('/data-akun'));
    }
    // public function save()
    // {
    //     if (!$this->validate([
    //         'fullname' => [
    //             'rules' => 'required',
    //             'errors' => [
    //                 'required' => 'Username Harus diisi',
    //             ]
    //         ],
    //         'username' => [
    //             'rules' => 'required|is_unique[akun.username]',
    //             'errors' => [
    //                 'required' => 'Username Harus diisi',
    //                 'is_unique' => 'Username tersebut sudah dipakai',
    //             ]
    //         ],
    //         'email' => [
    //             'rules' => 'required|is_unique[akun.email]',
    //             'errors' => [
    //                 'required' => 'Username Harus diisi',
    //                 'is_unique' => 'Username tersebut sudah dipakai',
    //             ]
    //         ],
    //         'password_hash' => [
    //             'rules' => 'required',
    //             'errors' => [
    //                 'required' => 'Warna Harus diisi'

    //             ]
    //         ],
    //         'confpassword' => [
    //             'rules' => 'matches[password_hash]',
    //             'errors' => [
    //                 'matches' => 'Konfirmasi password tidak cocok'
    //             ]
    //         ],
    //         'foto' => [
    //             'rules' => 'is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/gif,image/png]|max_size[foto,2048]',
    //             'errors' => [
    //                 'is_image' => 'File yang anda upload bukan gambar',
    //                 'mime_in' => 'File Extention Harus Berupa jpg,jpeg,gif,png',
    //                 'max_size' => 'Ukuran File Maksimal 2 MB'
    //             ]
    //         ]

    //     ])) {
    //         session()->setFlashdata('error', $this->validator->listErrors());
    //         return redirect()->back()->withInput();
    //     }
    //     // ambil gambar
    //     $fileFoto = $this->request->getFile('foto');

    //     //apakah tidak ada gambar yang diupload
    //     if ($fileFoto->getError() == 4) {
    //         $namaFoto = 'default-akun.png';
    //     } else {
    //         //generate nama 

    //         $namaFoto = $fileFoto->getRandomName();
    //         // pindahkan file ke folder img
    //         $fileFoto->move('img', $namaFoto);
    //     }

    //     $this->dataakunModel->save([
    //         'email' => $this->request->getVar('email'),
    //         'fullname' => $this->request->getVar('fullname'),
    //         'username' => $this->request->getVar('username'),
    //         'password_hash' => password_hash($this->request->getVar('password_hash'), PASSWORD_DEFAULT),
    //         'foto' => $namaFoto,
    //         'active' => 1,
    //     ]);
    //     $this->datagrubModel->save([
    //         'email' => $this->request->getVar('email'),
    //         'fullname' => $this->request->getVar('fullname'),
    //         'username' => $this->request->getVar('username'),
    //         'password_hash' => password_hash($this->request->getVar('password_hash'), PASSWORD_DEFAULT),
    //         'foto' => $namaFoto,
    //         'active' => 1,
    //     ]);
    //     session()->setFlashdata('pesan', 'Tambah Data Akun Berhasil');
    //     return redirect()->to('/data-akun');
    // }


    public function delete($id)
    {
        // cari gambar berdaasarkan id
        $akun = $this->dataakunModel->find($id);

        // cek jika gambar default-akun.png
        if ($akun['foto'] != 'default-avatar.jpg') {
            //hapus gambar
            unlink('img/' . $akun['foto']);
        }
        $groupModel = new GroupModel();
        $groupModel->removeUserFromAllGroups(intval($id));
        $this->dataakunModel->delete($id);
        session()->setFlashdata('pesan', 'Data Berhasil Dihapus.');
        return redirect()->to('/data-akun');
    }
    public function edit($id)
    {
        $dataakun = $this->dataakunModel->getAkun($id);
        if (empty($dataakun)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data Mobil Tidak ditemukan !');
        }

        $akun = $this->dataakunModel;
        $data = [
            'title' => 'Ubah Data Akun| SIA',
            'active'  => 'akun',
            'role' => $this->groups->getGroupsForUser(user()->id),
            'validation' => \Config\Services::validation(),
            'merk' => $this->dataakunModel->getAkun(),
            'dataakun' => $this->dataakunModel->getAkun($id)

        ];
        return view('data_akun/edit', $data);
    }

    public function update2($id_akun)
    {

        if (!$this->validate([
            'nama' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Username Harus diisi',
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
        $password = $this->request->getVar('password');
        if ($password == "") {
            $passwordLama = $this->request->getVar('passwordLama');
        } else {
            $passwordLama = password_hash($this->request->getVar('password'), PASSWORD_DEFAULT);
        }

        // ambil gambar
        $fileFoto = $this->request->getFile('foto');
        $fotoLama = $this->request->getVar('fotoLama');

        //apakah tidak ada gambar yang diupload
        if ($fileFoto->getError() == 4) {
            $namaFoto = $this->request->getVar('fotoLama');
        } elseif ($fotoLama == 'default-akun.png') {
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

        $this->dataakunModel->save([
            'id_akun' => $id_akun,
            'nama' => $this->request->getVar('nama'),
            'username' => $this->request->getVar('username'),
            'password' => $passwordLama,
            'foto' => $namaFoto

        ]);
        session()->setFlashdata('pesan', 'Ubah Data Akun Berhasil');
        return redirect()->to('/data-akun');
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

            $this->dataakunModel->save([
                'id' => $id,
                'email' => $this->request->getVar('email'),
                'fullname' => $this->request->getVar('fullname'),
                'jenis_kelamin' => $this->request->getVar('jenis_kelamin'),
                'alamat' => $this->request->getVar('alamat'),
                'username' => $this->request->getVar('username'),
                'password_hash' => $passwordLama,
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
                'password_hash' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Password Harus diisi'

                    ]
                ],
                'confpassword' => [
                    'rules' => 'matches[password_hash]',
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

            $this->dataakunModel->save([
                'id' => $id,
                'email' => $this->request->getVar('email'),
                'fullname' => $this->request->getVar('fullname'),
                'jenis_kelamin' => $this->request->getVar('jenis_kelamin'),
                'alamat' => $this->request->getVar('alamat'),
                'username' => $this->request->getVar('username'),
                'password_hash' => Password::hash($this->request->getVar('password_hash')),
                'foto' => $namaFoto

            ]);
        }
        session()->setFlashdata('pesan', 'Ubah Data Akun Berhasil');
        return redirect()->to('/data-akun');
    }

    public function detail($id)
    {
        $dataakun = $this->dataakunModel->getAkun($id);
        if (empty($dataakun)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data Mobil Tidak ditemukan !');
        }

        $akun = $this->dataakunModel;
        $data = [
            'title' => 'Ubah Data Akun| SIA',
            'active'  => 'akun',
            'role' => $this->groups->getGroupsForUser(user()->id),
            'validation' => \Config\Services::validation(),
            'merk' => $this->dataakunModel->where('id !=', 0)->getAkun(),
            'dataakun' => $this->dataakunModel->getAkun($id)

        ];
        return view('data_akun/detail', $data);
    }

    public function activate()
    {
        $userModel = new UserModel();

        $data = [
            'activate_hash' => null,
            'active' => $this->request->getVar('active') == '0' || '' ? '1' : '0',
        ];
        $userModel->update($this->request->getVar('id'), $data);

        return redirect()->to(base_url('/data-akun'));
    }

    public function changePassword($id = null)
    {
        if ($id == null) {
            return redirect()->to(base_url('/users/index'));
        } else {
            $data = [
                'id' => $id,
                'title' => 'Update Password',
            ];
            return view('data_akun/set_password', $data);
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

            return view('data_akun/set_password', $data);
        } else {
            $userModel = new UserModel();
            $data = [
                'password_hash' => Password::hash($this->request->getVar('password')),
                'reset_hash' => null,
                'reset_at' => null,
                'reset_expires' => null,
            ];
            $userModel->update($this->request->getVar('id'), $data);

            return redirect()->to(base_url('/data-akun'));
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

        return redirect()->to(base_url('/data-akun'));
    }
}
