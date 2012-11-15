<?php
/*
 * Copyright 2010 Stian Liknes <stianlik@gmail.com>. All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without modification, are
 * permitted provided that the following conditions are met:
 *
 * 1. Redistributions of source code must retain the above copyright notice, this list of
 * conditions and the following disclaimer.
 *
 * 2. Redistributions in binary form must reproduce the above copyright notice, this list
 * of conditions and the following disclaimer in the documentation and/or other materials
 * provided with the distribution.
 *
 * THIS SOFTWARE IS PROVIDED BY Stian Liknes <stianlik@gmail.com> ``AS IS'' AND ANY EXPRESS OR IMPLIED
 * WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND
 * FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL <COPYRIGHT HOLDER> OR
 * CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR
 * SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON
 * ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING
 * NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF
 * ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * The views and conclusions contained in the software and documentation are those of the
 * authors and should not be interpreted as representing official policies, either expressed
 * or implied, of Stian Liknes <stianlik@gmail.com>.
 */

/**
 * Used to configure PayPal accounts. To use multiple accounts you can
 * change this into an active record.
 *
 * CREATED: 2010-10-23
 * UPDATED: 2010-10-26
 *
 * @author StianLiknes <stianlik@gmail.com>
 */
class PPAccount extends CModel {
	public $username;
	public $password;
	public $signature;
	public $email;
	public $identityToken;

	public function attributeNames() {
		return array(
			'username',
			'password',
			'signature',
			'email',
			'identityToken',
		);
	}

	public function getNvp() {
		return array(
			'USER'=>$this->username,
			'PWD'=>$this->password,
			'SIGNATURE'=>$this->signature,
		);
	}
}

?>