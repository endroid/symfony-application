### jwt ###
ifndef APP_ENV
	include .env
endif

###> lexik/jwt-authentication-bundle ###
OPENSSL_BIN := $(shell which openssl)
generate-jwt-keys: ## Generates JWT auth keys
ifndef OPENSSL_BIN
	$(error "Unable to generate keys (needs OpenSSL)")
endif
	mkdir -p config/jwt
	openssl genrsa -passout pass:${JWT_PASSPHRASE} -out ${JWT_SECRET_KEY} -aes256 4096
	openssl rsa -passin pass:${JWT_PASSPHRASE} -pubout -in ${JWT_SECRET_KEY} -out ${JWT_PUBLIC_KEY}
	@echo "\033[32mRSA key pair successfully generated\033[39m"
###< lexik/jwt-authentication-bundle ###
### end ###
