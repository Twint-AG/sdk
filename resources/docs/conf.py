import json
from pathlib import Path
from datetime import datetime

# Configuration file for the Sphinx documentation builder.
#
# For the full list of built-in configuration values, see the documentation:
# https://www.sphinx-doc.org/en/master/usage/configuration.html

# -- Project information -----------------------------------------------------
# https://www.sphinx-doc.org/en/master/usage/configuration.html#project-information


def read_composer_json():
    with open(Path(__file__).parent.joinpath("../..", "composer.json")) as f:
        return json.load(f)


def year_range(start):
    end = datetime.now().year
    return str(start) if start == end else f"{start}–{end}"


composer_json = read_composer_json()

project = "TWINT PHP SDK"
copyright = year_range(2024) + ", TWINT AG"
author = ", ".join(map(lambda v: v["name"], composer_json["authors"]))

# -- General configuration ---------------------------------------------------
# https://www.sphinx-doc.org/en/master/usage/configuration.html#general-configuration

extensions = [
    "sphinx.ext.todo",
]
todo_include_todos = True

templates_path = []
exclude_patterns = []

nitpicky = True

# -- Options for HTML output -------------------------------------------------
# https://www.sphinx-doc.org/en/master/usage/configuration.html#options-for-html-output

html_theme = "alabaster"
html_theme_options = {
    "show_powered_by": False,
    "github_user": "Twint-AG",
    "github_repo": "sdk",
}
html_static_path = []
html_show_sphinx = False

smartquotes = True

highlight_options = {
    "PHP": {"startinline": True},
}
