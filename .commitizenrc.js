module.exports = {
  types: [
    {
      value: 'feat',
      name: 'feat:     A new feature',
    },
    {
      value: 'fix',
      name: 'fix:      A bug fix',
    },
    {
      value: 'chore',
      name: `chore:    Changes to the build process or auxiliary tools
              and libraries such as documentation generation`,
    },
    {
      value: 'refactor',
      name: 'refactor: A code change that neither fixes a bug nor adds a feature',
    },
    {
      value: 'docs',
      name: 'docs:     Documentation only changes',
    },
    {
      value: 'style',
      name: `style:    Changes that do not affect the meaning of the code
              (white-space, formatting, missing semi-colons, etc)`,
    },
    {
      value: 'perf',
      name: 'perf:     A code change that improves performance',
    },
    {
      value: 'test',
      name: 'test:     Adding missing tests',
    },
    {
      value: 'revert',
      name: 'revert:   Revert to a commit',
    },
  ],

  scopes: [],

  allowTicketNumber: false,
  wipDefaultChoice: false,
  wipPrefix: 'w',

  allowCustomScopes: true,
  allowEmptyScopes: true,
  allowScopeWithWip: true,
  defaultScopeInFirst: true,
  allowBreakingChanges: ['feat', 'fix', 'perf', 'refactor'],
  skipQuestions: ['body', 'footer', 'breaking'],
}
