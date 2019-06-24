# WordPress on Lambda

Use at your own caution!!!

[Read more](https://keita.blog/?p=1796)

## How To Use

```bash
$ sam package --template-file template.yaml --output-template-file serverless-output.yaml --s3-bucket "$DEPLOY_BUCKET"
$ sam deploy --template-file serverless-output.yaml --stack-name wordpress-on-lambda --capabilities CAPABILITY_IAM
$ aws s3 sync ./src/php s3://deploy-bucket-XXXXX/prod --exclude "*.php" --exclude "*.ini"
```
