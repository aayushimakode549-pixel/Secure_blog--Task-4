echo "*.php linguist-language=PHP" > .gitattributes
git add .gitattributes
git commit -m "Fix language detection to 100% PHP"
git push
